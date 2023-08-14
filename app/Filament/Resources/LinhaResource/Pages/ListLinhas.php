<?php

namespace App\Filament\Resources\LinhaResource\Pages;

use App\Filament\Resources\LinhaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLinhas extends ListRecords
{
    protected static string $resource = LinhaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
