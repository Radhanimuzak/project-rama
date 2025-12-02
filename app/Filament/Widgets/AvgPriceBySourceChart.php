<?php

namespace App\Filament\Widgets;

use App\Models\Leadsdata;
use Filament\Widgets\ChartWidget;

class AvgPriceBySourceChart extends ChartWidget
{
    protected ?string $heading = 'Fixed Price by Source';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Leadsdata::selectRaw('source_leads, SUM(fixed_price) as total_price')
            ->groupBy('source_leads')
            ->pluck('total_price', 'source_leads')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Avg Target Price (RM)',
                    'data' => array_values($data),
                    'backgroundColor' => [
                        '#E1306C', // Instagram pink
                        '#1877F2', // Facebook blue
                        '#000000', // TikTok black
                        '#25D366', // WhatsApp green
                    ],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}