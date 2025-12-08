<?php

namespace App\Filament\LeadsdataMarkettings\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Leadsdata;

class LeadsChartMarketting extends ChartWidget
{
    protected ?string $heading = 'LEADS BY SOURCE';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Leadsdata::selectRaw('source_leads, COUNT(*) as count')
            ->groupBy('source_leads')
            ->pluck('count', 'source_leads')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'TOTAL LEADS',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        'rgba(30, 58, 138, 0.8)',
                        'rgba(96, 165, 250, 0.8)',
                        'rgba(18, 36, 83, 0.8)',
                        'rgba(147, 197, 253, 0.8)',
                    ],
                    'borderColor' => [
                        'rgb(30, 58, 138)',
                        'rgb(96, 165, 250)',
                        'rgb(18, 36, 83)',
                        'rgb(147, 197, 253)',
                    ],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'hoverBackgroundColor' => [
                        'rgba(30, 58, 138, 1)',
                        'rgba(96, 165, 250, 1)',
                        'rgba(18, 36, 83, 1)',
                        'rgba(147, 197, 253, 1)',
                    ],
                ],
            ],
            'labels' => array_map('strtoupper', array_keys($data)),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'color' => 'rgb(30, 58, 138)',
                        'font' => [
                            'size' => 12,
                            'weight' => 'bold',
                        ],
                        'padding' => 15,
                    ],
                ],
            ],
        ];
    }
}
