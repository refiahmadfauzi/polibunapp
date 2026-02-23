<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TopPharmacyItemChart extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Item Farmasi';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
                    'data' => [320, 280, 250, 220, 190, 160, 140, 120, 100, 80],
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#059669',
                ],
            ],
            'labels' => [
                'Paracetamol', 'Amoxicillin', 'Omeprazole', 'Cetirizine', 'Vitamin C',
                'Antasida', 'Ibuprofen', 'Dexamethasone', 'Salbutamol', 'Metformin',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
        ];
    }
}
