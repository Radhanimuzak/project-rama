<?php

namespace App\Filament\Resources\LeadsdataMarkettings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class LeadsdataMarkettingForm // ✅ Fixed class name
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->required(),
                TextInput::make('sales_name')
                    ->disabled(),
                TextInput::make('contact_number')
                    ->required(),
                TextInput::make('product')
                    ->required(),
                Select::make('status')
                    ->disabled()
                    ->label('Status')
                    ->searchable()
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
                    ->disabled(),
                Select::make('method')
                    ->label('Meeting Method')
                    ->disabled() // User can see but not edit
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
                    ->inputMode('numeric')
                    ->disabled(),
            ]);
    }
}