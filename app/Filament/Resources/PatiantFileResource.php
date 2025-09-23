<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PatiantFileResource\Pages;
use App\Filament\Resources\PatiantFileResource\RelationManagers;
use App\Models\PatiantFile;
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


class PatiantFileResource extends Resource
{
    protected static ?string $model = PatiantFile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Patiant Files ';



    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('viewAny', static::getModel());
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('patiant_id')->label('Patiant')
                ->options(Patiant::all()->pluck('name', 'id')->toArray()) // استخدم toArray() هنا
                ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);']),

            Forms\Components\TextInput::make('filePath')->required(),

            Select::make('type')
            ->label('type')
            ->options([
                'image'=> 'image',
                'pdf' => 'pdf',
            ])->required()
           ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
          ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('patiant.name')->label('Patiant')->searchable(),
                TextColumn::make('filePath'),
                TextColumn::make('type')
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
            'index' => Pages\ListPatiantFiles::route('/'),
            'create' => Pages\CreatePatiantFile::route('/create'),
            'edit' => Pages\EditPatiantFile::route('/{record}/edit'),
        ];
    }    
}
