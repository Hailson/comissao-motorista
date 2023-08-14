<?php

namespace App\Filament\Resources\PassagemResource\Pages;

use App\Filament\Resources\PassagemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPassagems extends ListRecords
{
    protected static string $resource = PassagemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
