<?php

namespace App\Filament\Resources\PatiantFileResource\Pages;

use App\Filament\Resources\PatiantFileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatiantFile extends EditRecord
{
    protected static string $resource = PatiantFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
