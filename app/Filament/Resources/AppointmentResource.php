<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn ; 
use Filament\Forms\Components\Select;
use App\Models\User ;
use App\Models\Patiant ;
use Filament\Forms\Components\TextInput; 



class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Appointment';


    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('viewAny', static::getModel());
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('doctor_id')->label('Doctor')
                ->options(User::all()->where('role','doctor')->pluck('name', 'id')->toArray()) // استخدم toArray() هنا
                ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);']),
                
                Select::make('patiant_id')->label('Patiant')
                ->options(Patiant::all()->pluck('name', 'id')->toArray()) // استخدم toArray() هنا
                ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);']),

                Forms\Components\DateTimePicker::make('date')->required()
                ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                
                    ,

                    Select::make('status')
                    ->label('status')
                    ->options([
                      
                        'completed' => 'completed',
                        'canceled' => 'canceled',
                        'schedualed' => 'schedualed'
                    ])
                    ->required()
                    ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);']),

                
              TextInput::make('reseon')->required()    
                        ->extraAttributes(['style'=>'color : #FFD700 ; background-color: rgba(0,0 ,255.1,0.1);'])
                            ,
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('doctor.name')
                ->label('Doctor')
                ->searchable() ,

             TextColumn::make('patiant.name')->label('Patiant')->searchable(),

             TextColumn::make('date')->dateTime(),


             TextColumn::make('reseon'),
            Tables\Columns\BadgeColumn::make('status'),

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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }    
}
