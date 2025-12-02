<?php

namespace App\Filament\Resources\Leadsdatas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LeadsdataInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('customer_name'),
                TextEntry::make('sales_name'),
                TextEntry::make('contact_number'),
                TextEntry::make('product'),
                TextEntry::make('status'),
                TextEntry::make('source_leads'),
                TextEntry::make('method'),
                TextEntry::make('target_price'),
                TextEntry::make('fixed_price'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
