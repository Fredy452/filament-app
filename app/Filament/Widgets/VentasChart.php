<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;

class VentasChart extends LineChartWidget
{
    protected static ?string $heading = 'Ventas por mes';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Ventas',
                    'data' => [4344, 5676, 6798, 7890, 8987, 9388, 10343, 10524, 13664, 14345, 15753],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
