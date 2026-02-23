<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class TopDiagnosisChart extends ChartWidget
{
    protected static ?string $heading = 'Top 10 Diagnosa';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kasus',
                    'data' => [85, 72, 65, 58, 50, 42, 38, 30, 25, 20],
                    'backgroundColor' => [
                        '#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6',
                        '#ec4899', '#14b8a6', '#f97316', '#6366f1', '#84cc16',
                    ],
                ],
            ],
            'labels' => [
                'ISPA', 'Hipertensi', 'Diabetes', 'Gastritis', 'Dermatitis',
                'Migrain', 'Anemia', 'Asma', 'Vertigo', 'Conjunctivitis',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
