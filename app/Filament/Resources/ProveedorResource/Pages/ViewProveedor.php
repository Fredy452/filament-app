<?php

namespace App\Filament\Resources\ProveedorResource\Pages;

use App\Filament\Resources\ProveedorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProveedor extends ViewRecord
{
    protected static string $resource = ProveedorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
