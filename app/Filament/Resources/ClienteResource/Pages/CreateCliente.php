<?php

namespace App\Filament\Resources\ClienteResource\Pages;

use App\Filament\Resources\ClienteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCliente extends CreateRecord
{
    protected static string $resource = ClienteResource::class;

     // Despues de crear el post redirijimos al index
     protected function getRedirectUrl(): string
     {
         return $this->getResource()::getUrl('index');
     }
}
