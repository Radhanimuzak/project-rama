<?php

namespace App\Filament\Resources\LeadsdataSales\Pages;

use App\Filament\Resources\LeadsdataSales\LeadsdataSalesResource;
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
