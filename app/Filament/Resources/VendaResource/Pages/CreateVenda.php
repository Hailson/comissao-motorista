<?php

namespace App\Filament\Resources\VendaResource\Pages;

use App\Filament\Resources\VendaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVenda extends CreateRecord
{
    protected static string $resource = VendaResource::class;

   /*
     protected function mutateFormDataBeforeCreate(array $data): array
    {
        //$dados = [$data];

        //($dados);

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

}
