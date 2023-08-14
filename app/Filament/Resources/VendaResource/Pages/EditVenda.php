<?php

namespace App\Filament\Resources\VendaResource\Pages;

use App\Filament\Resources\VendaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVenda extends EditRecord
{
    protected static string $resource = VendaResource::class;
/*
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if($data['paga_comissao'] == false && $data['cobrador'] == null)
            {
                $data['comissao'] = $data['valor_total'] * 8 /100;
            }
            else
            {
                $data['comissao'] = null;
                $data['paga_comissao'] = true;
            }

            return $data;
            
    }
    */
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
