<?php

namespace App\Filament\Resources\LeadsdataSales;

use App\Filament\Resources\LeadsdataSales\Pages\CreateLeadsdataSales;
use App\Filament\Resources\LeadsdataSales\Pages\EditLeadsdataSales;
use App\Filament\Resources\LeadsdataSales\Pages\ListLeadsdataSales;
use App\Filament\Resources\LeadsdataSales\Pages\ViewLeadsdataSales;
use App\Filament\Resources\LeadsdataSales\Schemas\LeadsdataSalesForm;
use App\Filament\Resources\LeadsdataSales\Schemas\LeadsdataInfolistSales;
use App\Filament\Resources\LeadsdataSales\Tables\LeadsdataSalesTable;
use App\Models\Leadsdata;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Resources\Resource;


class LeadsdataSalesResource extends Resource
{
    protected static ?string $model = Leadsdata::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Leadsdatasales';

    public static function form(Schema $schema): Schema
    {
        return LeadsdataSalesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeadsdataSalesTable::configure($table);
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
            'index' => ListLeadsdataSales::route('/'),
            // 'create' => CreateLeadsdataSales::route('/create'),
            // 'edit' => EditLeadsdataSales::route('/{record}/edit'),
        ];
    }
}
