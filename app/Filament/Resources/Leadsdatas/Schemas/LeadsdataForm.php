<?php

namespace App\Filament\Resources\Leadsdatas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;


class LeadsdataForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('sales_name')
                    ->required(),
                TextInput::make('contact_number')
                    ->required(),
                TextInput::make('product')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->searchable()
                    ->required()
                    ->options([
                        'waiting' => 'Waiting',
                        'approved' => 'Approved',                 
                        'rejected' => 'Rejected',
                        'followup' => 'Follow Up',
                    ]),
                Select::make('source_leads')
                    ->label('Lead Source')
                    ->searchable()
                    ->required()
                    ->options([
                        'tiktok' => 'Tiktok',
                        'facebook' => 'Facebook',                 
                        'instagram' => 'Instagram',
                        'linkedin' => 'Linkedin',
                    ]),
                Textarea::make('note')
                    ->default(null)
                    ->columnSpanFull(),
                select::make('method')
                    ->label('Meeting Method')
                    ->searchable()
                    ->required()
                    ->options([
                        'gmeet' => 'Google Meet',
                        'zoom' => 'Zoom',                 
                        'call' => 'By Call',
                        'meetup' => 'Meet Up',
                    ]),
                TextInput::make('target_price')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->prefix('RM')
                    ->inputMode('numeric'),
                TextInput::make('fixed_price')
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->prefix('RM')
                    ->inputMode('numeric'),
            ]);
    }
}
