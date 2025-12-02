<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use App\Models\Leadsdata;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget

{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Leads', Leadsdata::count())
                ->description('Semua leads')
                ->icon('heroicon-o-users'),
            
            Stat::make('Leads Waiting', Leadsdata::where('status', 'waiting')->count())
                ->description('Menunggu follow up')
                ->color('warning'),
            
            Stat::make('Avg Target Price', 'RM ' . number_format(Leadsdata::avg('target_price'), 0))
                ->description('Rata-rata target'),
        ];
    }
}
