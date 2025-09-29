<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanResource\Pages;
use App\Filament\Resources\PlanResource\RelationManagers;
use App\Models\Plan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn ; 
use Filament\Forms\Components\TextInput; 

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Plan';


    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('viewAny', static::getModel());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
 
                TextInput::make('name')->required()    
                     ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                    ,

                
                    TextInput::make('price') // إضافة حقل price
                      ->numeric() // التأكد من أن الإدخال هو عدد
                      ->label('Price') // تسمية الحقل
                     ->placeholder('مثال: 12.34') // نص توضيحي
                     ->regex('/^\d+(\.\d{1,2})?$/') // تعبير منتظم للسماح برقم عشري برقمين بعد الفاصلة
                     ->helperText('أدخل رقم عشري برقمين بعد الفاصلة مثل: 12.34')
                     ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])

                    ,
                
                   TextInput::make('interval')->required()    
                   ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                  ,

                  TextInput::make('maxUsers')->required()    
                  ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                 ,

                 TextInput::make('features')->required()    
                     ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                    ,
                   

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')->searchable(),
                TextColumn::make('price'),
                TextColumn::make('interval'),
                TextColumn::make('maxUsers'),
                TextColumn::make('features')

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
            'index' => Pages\ListPlans::route('/'),
            'create' => Pages\CreatePlan::route('/create'),
            'edit' => Pages\EditPlan::route('/{record}/edit'),
        ];
    }    
}
