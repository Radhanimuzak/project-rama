<?php

namespace App\Filament\Resources\LeadsdataMarkettings\Pages;

use App\Filament\Resources\LeadsdataMarkettings\LeadsdataMarkettingResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeadsdataMarketting extends EditRecord
{
    protected static string $resource = LeadsdataMarkettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
