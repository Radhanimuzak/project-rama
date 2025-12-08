<?php

namespace App\Filament\LeadsDataSales\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Leadsdata;

class StatsOverviewSales extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Calculate counts by status (using actual database values)
        $waitingCount = Leadsdata::where('status', 'waiting')->count();
        $approvedCount = Leadsdata::where('status', 'approved')->count();
        $followUpCount = Leadsdata::where('status', 'follow-up')->count();
        $rejectedCount = Leadsdata::where('status', 'rejected')->count();

        // Calculate average target price from marketing (EXCLUDE REJECTED - no transaction)
        $avgTargetPrice = Leadsdata::where('status', '!=', 'rejected')
            ->whereNotNull('target_price')
            ->avg('target_price') ?? 0;

        // Calculate target fixed price (5% above target price for sales)
        $targetFixedPrice = $avgTargetPrice * 1.05;

        // Calculate average actual fixed price (EXCLUDE REJECTED - no transaction)
        $avgFixedPrice = Leadsdata::where('status', '!=', 'rejected')
            ->whereNotNull('fixed_price')
            ->avg('fixed_price') ?? 0;

        // Determine color based on performance:
        // RED: Below 95% (too low, losing money)
        // BLUE/PRIMARY: Between 95% - 105% (at target range)
        // GREEN: Above 105% (exceeding target, great!)
        $priceLower = $avgTargetPrice * 0.95;  // 5% below target
        $priceTarget = $avgTargetPrice * 1.05; // target (5% above)

        if ($avgFixedPrice < $priceLower) {
            $priceColor = 'danger';
            $priceDescription = '✗ BELOW TARGET (< 95%)';
            $priceIcon = 'heroicon-m-exclamation-triangle';
        } elseif ($avgFixedPrice >= $priceTarget) {
            $priceColor = 'success';
            $priceDescription = '✓ EXCEEDING TARGET (≥ 105%)';
            $priceIcon = 'heroicon-m-check-badge';
        } else {
            $priceColor = 'primary';
            $priceDescription = '◉ AT TARGET RANGE (95%-105%)';
            $priceIcon = 'heroicon-m-check-circle';
        }

        return [
            Stat::make('WAITING APPROVAL', $waitingCount)
                ->description('NEEDS SALES REVIEW')
                ->descriptionIcon('heroicon-m-clock')
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->chart([3, 5, 4, 6, 5, 7, 6, 8]),

            Stat::make('APPROVED', $approvedCount)
                ->description('SUCCESSFULLY CLOSED')
                ->descriptionIcon('heroicon-m-check-circle')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->chart([2, 3, 4, 5, 6, 7, 8, 9]),

            Stat::make('FOLLOW UP', $followUpCount)
                ->description('IN PROGRESS')
                ->descriptionIcon('heroicon-m-phone')
                ->icon('heroicon-o-phone')
                ->color('info')
                ->chart([4, 3, 5, 4, 6, 5, 7, 6]),

            Stat::make('REJECTED', $rejectedCount)
                ->description('NOT CONVERTED')
                ->descriptionIcon('heroicon-m-x-circle')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->chart([5, 4, 3, 4, 3, 2, 3, 2]),

            Stat::make('AVG TARGET PRICE', 'RM ' . number_format($avgTargetPrice, 0))
                ->description('FROM MARKETING')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->icon('heroicon-o-currency-dollar')
                ->color('info')
                ->chart([5, 4, 6, 7, 5, 6, 8, 7]),

            Stat::make('TARGET FIXED PRICE', 'RM ' . number_format($targetFixedPrice, 0))
                ->description('5% ABOVE TARGET (GOAL)')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-arrow-trending-up')
                ->color('primary')
                ->chart([5, 5, 6, 7, 6, 7, 8, 8]),

            Stat::make('ACTUAL FIXED PRICE', 'RM ' . number_format($avgFixedPrice, 0))
                ->description($priceDescription)
                ->descriptionIcon($priceIcon)
                ->icon('heroicon-o-banknotes')
                ->color($priceColor)
                ->chart([4, 5, 5, 6, 5, 7, 7, 6]),
        ];
    }
}
