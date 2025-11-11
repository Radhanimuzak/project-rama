<?php

namespace App\Filament\Resources\Leadsdatas\Pages;

use App\Filament\Resources\Leadsdatas\LeadsdataResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLeadsdata extends ViewRecord
{
    protected static string $resource = LeadsdataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
