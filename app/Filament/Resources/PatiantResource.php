<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatiantResource\Pages;
use App\Filament\Resources\PatiantResource\RelationManagers;
use App\Models\Patiant;
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


class PatiantResource extends Resource
{
    protected static ?string $model = Patiant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Patiant';


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
                TextInput::make('email ')->required()  
                       ->email()
                     ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                        ,

                TextInput::make('age')->required()    
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                            ,
                TextInput::make('phone')->required()  
                       ->tel()
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                                ,
                TextInput::make('address')->required()   
                        ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                                    ,

                Select::make('gender')
                        ->label('gender')
                        ->options([
                            'ذكر'=> 'male',
                            'انثى' => 'fmale',
                        ])->required()
                       ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                      ,

                Select::make('archived')
                     ->label('archived')
                     ->options([     
                        'Archived' => '1',
                        'NotArchived' => '0',
                             ])
                             ->reactive()
                             ->afterStateUpdated(fn(callable $set)=>$set('archived_at',null))
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);']),
                

                Forms\Components\DateTimePicker::make('archived_at') 
                ->required(fn(callable $get)=> $get('archived') === 'Archived')
                ->disabled(fn(callable $get)=> $get('archived') === 'NotArchived') // التأكد من أن الحقل مطلوب,
              
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
                TextColumn::make('email'),
                TextColumn::make('gender')
,                TextColumn::make('age'),
                TextColumn::make('phone '),
                TextColumn::make('address'),
                TextColumn::make('archived'),
                TextColumn::make('archived_at'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(fn($record) => auth()->user()->can('update', $record)),
        
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
            'index' => Pages\ListPatiants::route('/'),
            'create' => Pages\CreatePatiant::route('/create'),
            'edit' => Pages\EditPatiant::route('/{record}/edit'),
        ];
    }    
}
