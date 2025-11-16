<?php

namespace App\Filament\Resources\LeadsdataSales\Pages;

use App\Filament\Resources\LeadsdataSales\LeadsdataSalesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeadsdataSales extends ListRecords
{
    protected static string $resource = LeadsdataSalesResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make(),
    //     ];
    // }
}
