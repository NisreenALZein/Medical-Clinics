<?php

namespace App\Filament\Resources\PatiantResource\Pages;

use App\Filament\Resources\PatiantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatiants extends ListRecords
{
    protected static string $resource = PatiantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
