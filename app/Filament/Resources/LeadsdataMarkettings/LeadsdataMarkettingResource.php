<?php

namespace App\Filament\Resources\LeadsdataMarkettings;

use App\Filament\Resources\LeadsdataMarkettings\Pages\CreateLeadsdataMarketting;
use App\Filament\Resources\LeadsdataMarkettings\Pages\EditLeadsdataMarketting;
use App\Filament\Resources\LeadsdataMarkettings\Pages\ListLeadsdataMarkettings;
use App\Filament\Resources\LeadsdataMarkettings\Pages\ViewLeadsdataMarkettings;
use App\Filament\Resources\LeadsdataMarkettings\Schemas\LeadsdataMarkettingForm;
use App\Filament\Resources\LeadsdataMarkettings\Schemas\LeadsdataInfolistMarkettings;
use App\Filament\Resources\LeadsdataMarkettings\Tables\LeadsdataMarkettingsTable;
use App\Models\Leadsdata; // ✅ Import the correct model
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Resources\Resource;

class LeadsdataMarkettingResource extends Resource
{
    protected static ?string $model = Leadsdata::class; // ✅ Fixed - use existing model

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'customer_name'; // ✅ Changed to actual field

    protected static ?string $slug = 'LeadsData';

    protected static ?string $navigationLabel = 'Marketing Leads Data';


    public static function form(Schema $schema): Schema
    {
        return LeadsdataMarkettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeadsdataMarkettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLeadsdataMarkettings::route('/'),
            // 'create' => CreateLeadsdataMarketting::route('/create'),
            // 'edit' => EditLeadsdataMarketting::route('/{record}/edit'),
        ];
    }
}