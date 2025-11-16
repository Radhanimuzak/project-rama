<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UsersResource;
use Filament\Resources\Pages\DeleteRecord;
use Filament\Actions\DeleteAction;

class DeleteLeadsdataSales extends DeleteRecord
{
 protected static string $resource = UsersResource::class;

    protected function getHeaderActions(): array
    {
        return [
        DeleteAction::make()->successNotificationTitle('User deleted'),
        ];
    }
}