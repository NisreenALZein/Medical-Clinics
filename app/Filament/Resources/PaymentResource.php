<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
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
use App\Models\Subscription ;
use Filament\Forms\Components\DatePicker ;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Payment';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('viewAny', static::getModel() );
    }

       public static function canView($record): bool
          {
        return auth()->user()?->can('view', $record)??false;
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
               Select::make('subscription_id')
                 ->label('Subscription')
                 ->required()
                ->searchable()
                ->options(function () {
                           // جلب كل الاشتراكات مع المستخدم والباقة
                 return Subscription::with(['user', 'plan'])->get()
                     ->mapWithKeys(function ($subscription) {
                   return [
                    $subscription->id => $subscription->user->name . ' - ' . $subscription->plan->name
                     ];
                      });
                    })
                   ,
              
               TextInput::make('amount') // إضافة حقل price
               ->numeric() // التأكد من أن الإدخال هو عدد
               ->label('amount') // تسمية الحقل
              ->placeholder('مثال: 12.34') // نص توضيحي
              ->regex('/^\d+(\.\d{1,2})?$/') // تعبير منتظم للسماح برقم عشري برقمين بعد الفاصلة
              ->helperText('أدخل رقم عشري برقمين بعد الفاصلة مثل: 12.34')
              ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
              ->required()
              ,
               Select::make('status')
                    ->label('status')
                    ->options([
                        'success' => 'success',
                        'failed' => 'failed',
                        'pending' => 'pending'
                    ])
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                    ,
    
                    DatePicker::make('paid_at')
                    ->label('paid_at')
                    ->default(now()) // إذا ما حدد المستخدم، بياخذ الآن
                    ->required()
                    ,

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //

                Tables\Columns\TextColumn::make('subscription.user.name')
                ->label('User'),

            Tables\Columns\TextColumn::make('subscription.plan.name')
                ->label('Plan'),

            Tables\Columns\TextColumn::make('amount')
                ->label('amount'),

            Tables\Columns\TextColumn::make('transaction_id')
                ->label('transaction_id'),

            Tables\Columns\BadgeColumn::make('status')
                ->label('status')
                ,

            Tables\Columns\TextColumn::make('paid_at')
                ->label('paid_at')
                ->dateTime(),
        
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
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }    
}
