<?php

namespace App\Filament\Resources\PassagemResource\Pages;

use App\Filament\Resources\PassagemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePassagem extends CreateRecord
{
    protected static string $resource = PassagemResource::class;
    

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['valor_total'] = number_format(($data['valor_total'] /100), 2, ',', '.');

        return $data;
    }
}
