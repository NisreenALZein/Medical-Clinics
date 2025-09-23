<?php

namespace App\Filament\Resources\PatiantResource\Pages;

use App\Filament\Resources\PatiantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatiant extends EditRecord
{
    protected static string $resource = PatiantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
