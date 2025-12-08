<?php

namespace App\Filament\Resources\LeadsdataMarkettings\Tables;


use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Support\Enums\FontWeight;


class LeadsdataMarkettingsTable
{
    public static function configure(Table $table): Table
    {
       return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Customer Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::SemiBold),
                TextColumn::make('sales_name')
                    ->label('Sales Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact_number')
                    ->label('Contact Number')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Contact copied!'),
                TextColumn::make('product')
                    ->searchable()
                    ->badge(),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'waiting' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('source_leads')
                    ->label('Source')
                    ->searchable()
                    ->badge(),
                TextColumn::make('method')
                    ->searchable()
                    ->badge(),
                TextColumn::make('target_price')
                    ->label('Target Price')
                    ->searchable()
                    ->sortable()
                    ->money('MYR')
                    ->color('success'),
                TextColumn::make('fixed_price')
                    ->label('Fixed Price')
                    ->searchable()
                    ->sortable()
                    ->money('MYR')
                    ->color('primary'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
