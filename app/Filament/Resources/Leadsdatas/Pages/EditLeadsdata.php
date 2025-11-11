<?php

namespace App\Filament\Resources\Leadsdatas\Pages;

use App\Filament\Resources\Leadsdatas\LeadsdataResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLeadsdata extends EditRecord
{
    protected static string $resource = LeadsdataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}