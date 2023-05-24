<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
// Models
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Productos', Producto::count())
                ->description('32k increase')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer'
                ]),
            Card::make('Clientes', Cliente::count())
                ->description('1+ agregado')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('danger'),
            Card::make('Ventas', Venta::count())
                ->description('5+ ventas')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
