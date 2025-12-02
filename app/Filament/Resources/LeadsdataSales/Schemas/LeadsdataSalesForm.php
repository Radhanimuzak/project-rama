<?php

namespace App\Filament\Resources\LeadsdataSales\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class LeadsdataSalesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('customer_name')
                    ->disabled(),
                TextInput::make('sales_name')
                    ->required(),
                TextInput::make('contact_number')
                    ->disabled(),
                TextInput::make('product')
                    ->disabled(),
                Select::make('status')
                    ->required()
                    ->label('Status')
                    ->searchable()
                    ->options([
                        'waiting' => 'Waiting',
                        'approved' => 'Approved',                 
                        'rejected' => 'Rejected',
                        'followup' => 'Follow Up',
                    ]),
                Select::make('source_leads')
                    ->disabled()
                    ->label('Lead Source')
                    ->searchable()
                    ->options([
                        'tiktok' => 'Tiktok',
                        'facebook' => 'Facebook',                 
                        'instagram' => 'Instagram',
                        'linkedin' => 'Linkedin',
                    ]),
                Textarea::make('note')
                    ->required(),
                Select::make('method')
                    ->label('Meeting Method')
                    ->required()
                     // User can see but not edit
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
                    ->inputMode('numeric')
                    ->disabled(),
                TextInput::make('fixed_price')
                    ->required()
                    ->numeric()
                    ->integer()
                    ->minValue(0)
                    ->prefix('RM')
                    ->inputMode('numeric'),
                
            ]);
    }
}
