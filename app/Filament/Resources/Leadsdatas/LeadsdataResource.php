<?php

namespace App\Filament\Resources\Leadsdatas;

use App\Filament\Resources\Leadsdatas\Pages\CreateLeadsdata;
use App\Filament\Resources\Leadsdatas\Pages\EditLeadsdata;
use App\Filament\Resources\Leadsdatas\Pages\ListLeadsdatas;
use App\Filament\Resources\Leadsdatas\Pages\ViewLeadsdata;
use App\Filament\Resources\Leadsdatas\Schemas\LeadsdataForm;
use App\Filament\Resources\Leadsdatas\Schemas\LeadsdataInfolist;
use App\Filament\Resources\Leadsdatas\Tables\LeadsdatasTable;
use App\Models\Leadsdata;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LeadsdataResource extends Resource
{
    protected static ?string $model = Leadsdata::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'leadsdata';

    public static function form(Schema $schema): Schema
    {
        return LeadsdataForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LeadsdataInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LeadsdatasTable::configure($table);
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
            'index' => ListLeadsdatas::route('/'),
            'create' => CreateLeadsdata::route('/create'),
            'view' => ViewLeadsdata::route('/{record}'),
            'edit' => EditLeadsdata::route('/{record}/edit'),
        ];
    }
}
