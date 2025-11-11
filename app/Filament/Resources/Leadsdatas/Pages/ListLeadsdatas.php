<?php

namespace App\Filament\Resources\Leadsdatas\Pages;

use App\Filament\Resources\Leadsdatas\LeadsdataResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeadsdatas extends ListRecords
{
    protected static string $resource = LeadsdataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
