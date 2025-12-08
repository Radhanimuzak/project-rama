<?php

namespace App\Filament\LeadsdataMarkettings\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Leadsdata;

class StatsOverviewMarketting extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Calculate averages for marketing (EXCLUDE REJECTED - no transaction)
        $totalLeads = Leadsdata::count();
        $waitingLeads = Leadsdata::where('status', 'waiting')->count();
        $avgTargetPrice = Leadsdata::where('status', '!=', 'rejected')
            ->whereNotNull('target_price')
            ->avg('target_price') ?? 0;

        // Pricing guidelines for sales
        $salesTargetPrice = $avgTargetPrice * 1.05; // Sales must aim 5% above
        $minDiscountPrice = $avgTargetPrice * 0.95; // Max discount 5% below
        $maxAllowedPrice = $avgTargetPrice * 1.10; // Max 10% above

        return [
            Stat::make('TOTAL LEADS', $totalLeads)
                ->description('ALL MARKETING LEADS')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-users')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('WAITING APPROVAL', $waitingLeads)
                ->description('PENDING SALES APPROVAL')
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->chart([4, 5, 3, 6, 4, 7, 6, 5]),

            Stat::make('AVG TARGET PRICE', 'RM ' . number_format($avgTargetPrice, 0))
                ->description('BASE PRICE FROM MARKETING')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->icon('heroicon-o-currency-dollar')
                ->color('info')
                ->chart([5, 4, 6, 7, 5, 6, 8, 7]),

            Stat::make('SALES TARGET (+5%)', 'RM ' . number_format($salesTargetPrice, 0))
                ->description('SALES MUST AIM THIS PRICE')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-arrow-trending-up')
                ->color('success')
                ->chart([5, 5, 6, 7, 6, 7, 8, 8]),

            Stat::make('MIN DISCOUNT (-5%)', 'RM ' . number_format($minDiscountPrice, 0))
                ->description('MAXIMUM DISCOUNT ALLOWED')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->icon('heroicon-o-arrow-trending-down')
                ->color('danger')
                ->chart([6, 5, 5, 4, 5, 4, 4, 3]),

            Stat::make('PRICE RANGE', 'RM ' . number_format($minDiscountPrice, 0) . ' - RM ' . number_format($salesTargetPrice, 0))
                ->description('ACCEPTABLE RANGE (95%-105%)')
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-check-circle')
                ->color('primary')
                ->chart([4, 5, 5, 6, 5, 6, 6, 7]),
        ];
    }
}
