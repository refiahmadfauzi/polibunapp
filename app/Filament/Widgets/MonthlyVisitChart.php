<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class MonthlyVisitChart extends ChartWidget
{
    protected static ?string $heading = 'Kunjungan per Bulan';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kunjungan',
                    'data' => [120, 150, 180, 200, 170, 190, 220, 250, 230, 210, 195, 240],
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#2563eb',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
