<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Leadsdata;

class LeadsChart extends ChartWidget
{
    protected ?string $heading = 'Leads by Source'; // hapus static

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
                    'label' => 'Jumlah Leads',
                    'data' => array_values($data),
                    'backgroundColor' => ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                ],
            ],
            'labels' => array_keys($data),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
