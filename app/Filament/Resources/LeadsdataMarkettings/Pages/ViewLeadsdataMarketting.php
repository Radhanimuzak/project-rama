<?php

namespace App\Filament\Resources\LeadsdataMarkettings\Pages;

use App\Filament\Resources\LeadsdataMarkettings\LeadsdataMarkettingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLeadsdataMarkettings extends ViewRecord
{
    protected static string $resource = LeadsdataMarkettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
