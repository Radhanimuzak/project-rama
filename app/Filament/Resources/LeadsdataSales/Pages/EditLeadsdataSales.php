<?php

namespace App\Filament\Resources\LeadsdataSales\Pages;

use App\Filament\Resources\LeadsdataSales\LeadsdataSalesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeadsdataSales extends EditRecord
{
    protected static string $resource = LeadsdataSalesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
