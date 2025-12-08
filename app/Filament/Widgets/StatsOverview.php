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
        // Calculate averages
        $avgTargetPrice = Leadsdata::avg('target_price') ?? 0;
        $avgFixedPrice = Leadsdata::avg('fixed_price') ?? 0;
        $avgProfit = $avgFixedPrice - $avgTargetPrice;

        return [
            Stat::make('TOTAL LEADS', Leadsdata::count())
                ->description('ALL LEADS IN SYSTEM')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('LEADS WAITING', Leadsdata::where('status', 'waiting')->count())
                ->description('AWAITING FOLLOW UP')
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->chart([4, 5, 3, 6, 4, 7, 6, 5]),

            Stat::make('AVG TARGET PRICE', 'RM ' . number_format($avgTargetPrice, 0))
                ->description('AVERAGE TARGET VALUE')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->icon('heroicon-o-currency-dollar')
                ->color('info')
                ->chart([5, 4, 6, 7, 5, 6, 8, 7]),

            Stat::make('AVG FIXED PRICE', 'RM ' . number_format($avgFixedPrice, 0))
                ->description('AVERAGE FIXED VALUE')
                ->descriptionIcon('heroicon-m-banknotes')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->chart([4, 5, 5, 6, 5, 7, 7, 6]),

            Stat::make('AVG PROFIT', 'RM ' . number_format($avgProfit, 0))
                ->description('AVERAGE PROFIT MARGIN')
                ->descriptionIcon('heroicon-m-chart-bar')
                ->icon('heroicon-o-chart-bar')
                ->color($avgProfit > 0 ? 'success' : 'danger')
                ->chart([3, 4, 5, 6, 6, 7, 8, 8]),
        ];
    }
}
