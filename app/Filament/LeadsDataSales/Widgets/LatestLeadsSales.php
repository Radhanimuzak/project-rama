<?php

namespace App\Filament\LeadsDataSales\Widgets;

use App\Models\Leadsdata;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLeadsSales extends BaseWidget
{
    protected static ?string $heading = 'ALL LEADS - SALES DASHBOARD';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Leadsdata::query()->latest()->limit(10))
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('CUSTOMER NAME')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-m-user'),
                Tables\Columns\TextColumn::make('product')
                    ->label('PRODUCT')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-shopping-bag'),
                Tables\Columns\TextColumn::make('source_leads')
                    ->label('SOURCE')
                    ->badge()
                    ->icon('heroicon-m-globe-alt'),
                Tables\Columns\TextColumn::make('status')
                    ->label('STATUS')
                    ->badge()
                    ->icon('heroicon-m-check-circle')
                    ->color(fn (string $state): string => match ($state) {
                        'waiting' => 'warning',
                        'approved' => 'success',
                        'follow-up' => 'info',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('target_price')
                    ->label('TARGET PRICE')
                    ->money('MYR')
                    ->icon('heroicon-m-currency-dollar')
                    ->color('info')
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('target_fixed_price')
                    ->label('TARGET FIXED (5%)')
                    ->money('MYR')
                    ->icon('heroicon-m-arrow-trending-up')
                    ->state(function ($record) {
                        return ($record->target_price ?? 0) * 1.05;
                    })
                    ->color('primary')
                    ->weight('semibold')
                    ->description('SALES GOAL'),
                Tables\Columns\TextColumn::make('fixed_price')
                    ->label('ACTUAL FIXED PRICE')
                    ->money('MYR')
                    ->icon('heroicon-m-banknotes')
                    ->color(function ($record) {
                        if (!$record->target_price || !$record->fixed_price) {
                            return 'gray';
                        }
                        $targetLower = $record->target_price * 0.95;  // 5% below
                        $targetGoal = $record->target_price * 1.05;   // 5% above (goal)

                        // RED: Below 95% (too low)
                        // BLUE/PRIMARY: Between 95% - 105% (at target)
                        // GREEN: Above 105% (exceeding target!)
                        if ($record->fixed_price < $targetLower) {
                            return 'danger';
                        } elseif ($record->fixed_price >= $targetGoal) {
                            return 'success';
                        } else {
                            return 'primary';
                        }
                    })
                    ->weight('bold')
                    ->description(function ($record) {
                        if (!$record->target_price || !$record->fixed_price) {
                            return '';
                        }
                        $targetLower = $record->target_price * 0.95;
                        $targetGoal = $record->target_price * 1.05;

                        if ($record->fixed_price < $targetLower) {
                            return '✗ BELOW TARGET (< 95%)';
                        } elseif ($record->fixed_price >= $targetGoal) {
                            return '✓ EXCEEDING TARGET (≥ 105%)';
                        } else {
                            return '◉ AT TARGET RANGE (95%-105%)';
                        }
                    }),
                Tables\Columns\TextColumn::make('profit')
                    ->label('PROFIT')
                    ->money('MYR')
                    ->icon('heroicon-m-chart-bar')
                    ->state(function ($record) {
                        return ($record->fixed_price ?? 0) - ($record->target_price ?? 0);
                    })
                    ->color(function ($record) {
                        $profit = ($record->fixed_price ?? 0) - ($record->target_price ?? 0);
                        return $profit >= 0 ? 'success' : 'danger';
                    })
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('CREATED AT')
                    ->dateTime()
                    ->sortable()
                    ->icon('heroicon-m-calendar')
                    ->color('gray'),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('FILTER BY STATUS')
                    ->options([
                        'waiting' => 'WAITING',
                        'approved' => 'APPROVED',
                        'follow-up' => 'FOLLOW-UP',
                        'rejected' => 'REJECTED',
                    ]),
            ]);
    }
}
