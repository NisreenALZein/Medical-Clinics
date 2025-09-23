<?php

namespace App\Filament\Resources\PatiantFileResource\Pages;

use App\Filament\Resources\PatiantFileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatiantFiles extends ListRecords
{
    protected static string $resource = PatiantFileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
