<?php

namespace App\Filament\Resources\VentaResource\Pages;

use App\Filament\Resources\VentaResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVenta extends CreateRecord
{
    protected static string $resource = VentaResource::class;

    public function hasCombinedRelationManagerTabsWithForm(): bool
{
    return true;
}
// protected function afterValidate(): void
// {
//     $form = $this->getForm();
//     $data = $form->getRecord();
//     // Runs before the form fields are saved to the database.
//     $total_venta = $data->venta_detalles->sum('precio');

//     // Asignar el total de venta al campo correspondiente
//     $data->total_venta = $total_venta;

//     // Guardar los datos modificados
//     $this->setRecord($data);
// }
// protected function mutateFormDataBeforeCreate(array $data): array
// {
//       // Obtener los productos de la venta
//       $productos = collect($data['productos']);

//       // Calcular el total de la venta
//       $total_venta = $productos->sum(function ($producto) {
//           return $producto['precio'] * $producto['cantidad'];
//       });

//       // Guardar el total de la venta en el array de datos
//       $data['total_venta'] = $total_venta;

//       // Devolver el array de datos modificado
//       return $data;
// }
}
