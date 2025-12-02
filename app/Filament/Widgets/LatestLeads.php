<?php

namespace App\Filament\Widgets;

namespace App\Filament\Widgets;

use App\Models\Leadsdata;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestLeads extends BaseWidget
{
    protected static ?string $heading = 'Latest Leads';

    protected static ?int $sort = 1;
    
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Leadsdata::query()->latest()->limit(5))
            ->columns([
                Tables\Columns\TextColumn::make('customer_name'),
                Tables\Columns\TextColumn::make('product'),
                Tables\Columns\TextColumn::make('source_leads')
                    ->badge(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'waiting' => 'warning',
                        'success' => 'success',
                        'failed' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('target_price')
                    ->money('MYR'),
                Tables\Columns\TextColumn::make('fixed_price')
                    ->money('MYR'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}