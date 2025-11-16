<?php

namespace App\Filament\Resources\LeadsdataMarkettings\Pages;

use App\Filament\Resources\LeadsdataMarkettings\LeadsdataMarkettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeadsdataMarkettings extends ListRecords
{
    protected static string $resource = LeadsdataMarkettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
