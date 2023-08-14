<?php

namespace App\Filament\Resources\LinhaResource\Pages;

use App\Filament\Resources\LinhaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinha extends EditRecord
{
    protected static string $resource = LinhaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
