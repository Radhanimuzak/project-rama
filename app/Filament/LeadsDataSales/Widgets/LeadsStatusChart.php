<?php

namespace App\Filament\LeadsDataSales\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Leadsdata;

class LeadsStatusChart extends ChartWidget
{
    protected ?string $heading = 'PROFIT BY SOURCE';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        // Get all sources and calculate profit for each
        $sources = Leadsdata::selectRaw('
                source_leads,
                SUM(COALESCE(fixed_price, 0) - COALESCE(target_price, 0)) as total_profit
            ')
            ->where('status', '!=', 'rejected')
            ->whereNotNull('source_leads')
            ->groupBy('source_leads')
            ->get();

        $profitData = [];
        foreach ($sources as $source) {
            $profitData[$source->source_leads] = $source->total_profit;
        }

        // If no data, show empty state
        if (empty($profitData)) {
            $profitData = ['NO DATA' => 0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'TOTAL PROFIT (RM)',
                    'data' => array_values($profitData),
                    'backgroundColor' => [
                        'rgba(30, 58, 138, 0.8)',   // primary - dark blue
                        'rgba(96, 165, 250, 0.8)',  // primary - light blue
                        'rgba(34, 197, 94, 0.8)',   // success - green
                        'rgba(251, 191, 36, 0.8)',  // warning - yellow
                        'rgba(239, 68, 68, 0.8)',   // danger - red
                        'rgba(147, 197, 253, 0.8)', // info - sky blue
                    ],
                    'borderColor' => [
                        'rgb(30, 58, 138)',
                        'rgb(96, 165, 250)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 191, 36)',
                        'rgb(239, 68, 68)',
                        'rgb(147, 197, 253)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => array_map('strtoupper', array_keys($profitData)),
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
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) {
                            let label = context.label || "";
                            if (label) {
                                label += ": ";
                            }
                            label += "RM " + context.parsed.toLocaleString();
                            return label;
                        }',
                    ],
                ],
            ],
        ];
    }
}
