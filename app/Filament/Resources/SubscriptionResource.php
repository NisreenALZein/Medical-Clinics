<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Models\Subscription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn ; 
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Plan ;
use App\Models\User ;
use Filament\Forms\Components\DatePicker ;



class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Subscription';


    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('viewAny', static::getModel() );
    }

    public static function canView($record):bool
    {
        return auth()->user()?->can('view', $record)??false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('user_id')
                ->label('User')
                ->options(function (callable $get) {
                    $planId = $get('plan_id');
                    if (! $planId) {
                        return User::pluck('name', 'id');
                    }
            
                    $plan = Plan::find($planId);
            
                    // إذا الباقة Starter => أظهر فقط الدكاترة
                    if ($plan && $plan->name === 'Starter') {
                        return User::where('role', 'doctor')->pluck('name', 'id');
                    }
            
                    // باقي الباقات => أظهر كل المستخدمين
                    return User::pluck('name', 'id');
                })
                ->required()
                ->searchable()
                ->reactive()
                ->rule(function (callable $get) {
                    return function (string $attribute, $value, \Closure $fail) use ($get) {
                        $planId = $get('plan_id');
                        if (! $planId) {
                            return ;
                        }
            
                        $plan = Plan::find($planId);
                        if (! $plan) {
                            return;
                        }
            
                        // عدد الاشتراكات الحالية للباقة
                        $currentUsersCount = Subscription::where('plan_id',$planId)->count();
            
                        // التحقق من وجود نفس الحساب مسبقاً في نفس الباقة
                        $userExists = Subscription::where('plan_id', $planId)
                            ->where('user_id', $value)
                            ->exists();
            
                        if ($userExists) {
                            $fail("هذا الحساب مسجّل مسبقًا في هذه الباقة.");
                            return;
                        }
            
                        // التحقق من الحد الأقصى للمستخدمين
                        if ($plan->maxUsers && $currentUsersCount >= $plan->maxUsers) {
                            $fail("لقد وصلت للحد الأقصى ({$plan->max_users}) من المستخدمين في هذه الباقة.");
                            return;
                        }
            
                        // تحقق إضافي: إذا الباقة Starter
                        if ($plan->name === 'Starter') {
                            $user = User::find($value);
            
                            // لازم يكون المستخدم دكتور
                            if ($user && $user->role !== 'doctor') {
                                $fail("في باقة Starter يجب أن يكون المستخدم دكتور فقط.");
                                return;
                            }
            
                            // لازم يكون حساب واحد فقط
                            if ($currentUsersCount >= 1) {
                                $fail("باقة Starter تسمح بدكتور واحد فقط.");
                                return;
                            }
                        }
                    };
                })
                    ,

                    Select::make('plan_id')
                     ->label('Plan')
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                    ->options(Plan::pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                         $set('endDate', self::calculateEndDateForPlan($state));
                         })
                    ,
                    DatePicker::make('startDate')
                    ->label('startDate')
                    ->default(now()) // إذا ما حدد المستخدم، بياخذ الآن
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $set('endDate', self::calculateEndDateForPlan($get('plan_id'), $state));
                    }),
                
                DatePicker::make('endDate')
                    ->label('endDate')
                    ->disabled()
                    ->default(fn ($get) => self::calculateEndDateForPlan($get('plan_id'), $get('startDate')))
                    ->dehydrated(true)
                    ->reactive(),

    
               Select::make('paymentGateway')
               ->label('PaymentGateway')
               ->options([
                   'stripe' => 'stripe',
                   'paytabs' => 'paytabs',
                   'checkout' => 'checkout'
               ])->required()
               ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
               

               ,
               Select::make('status')
                    ->label('status')
                    ->options([
                        'active' => 'active',
                        'canceled' => 'canceled',
                        'expired' => 'expired',
                        'pending' => 'pending'
                    ])->required()
                    ->disabled()
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);']),
                    

                    Select::make('autoRenew')
                    ->label('autoRenew')
                    ->options([
                        '1' => 'true',
                        '0' => 'false'
                    ])->required()
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);']),
                    
            ]);
    }

    protected static function calculateEndDateForPlan($planId, $startDate = null)
    {
        if (!$planId) {
            return null;
        }
    
        $plan = Plan::find($planId);
        if (!$plan) {
            return null;
        }
    
        $type = $plan->interval ?? 'monthly';
    
        // لو ما دخل المستخدم تاريخ بداية نستخدم الآن
        $start = $startDate 
            ? \Carbon\Carbon::parse($startDate) 
            : now();
    
        return match ($type) {
            'monthly' => $start->copy()->addMonth()->toDateString(), // 'YYYY-MM-DD'
            'yearly'  => $start->copy()->addYear()->toDateString(),
            default   => $start->toDateString(),
        };
    }
    


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('user.name')
                ->label('User') ,
                TextColumn::make('plan.name')
                ->label('Plan') ,
                TextColumn::make('startDate'),
                TextColumn::make('paymentGateway'),
                TextColumn::make('endDate'),
                TextColumn::make('autoRenew'),
                TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function afterSave($record): void
    {
        $record->updateStatusBasedOnPayments();
        $record->expireIfNeeded();
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }    
}
