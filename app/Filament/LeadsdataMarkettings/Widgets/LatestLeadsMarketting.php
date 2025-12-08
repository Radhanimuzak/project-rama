<?php

namespace App\Filament\LeadsdataMarkettings\Widgets;

use App\Models\Leadsdata;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLeadsMarketting extends BaseWidget
{
    protected static ?string $heading = 'LATEST LEADS - WAITING APPROVAL';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Leadsdata::query()->where('status', 'waiting')->latest()->limit(10))
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
                    ->icon('heroicon-m-clock')
                    ->color(fn (string $state): string => match ($state) {
                        'waiting' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('target_price')
                    ->label('TARGET PRICE')
                    ->money('MYR')
                    ->icon('heroicon-m-currency-dollar')
                    ->color('success')
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('CREATED AT')
                    ->dateTime()
                    ->sortable()
                    ->icon('heroicon-m-calendar')
                    ->color('gray'),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc');
    }
}
