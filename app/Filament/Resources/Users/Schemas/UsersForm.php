<?php

namespace App\Filament\Resources\Users\Schemas;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('email')
                    ->required()
                    ->email()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('password')
                    ->required()
                    ->password()
                    ->maxLength(255),
                Select::make('role')
                    ->label('role')
                    ->options([
                        'admin' => 'Admin',
                        'sales' => 'Sales',                 
                        'marketting' => 'Marketting',
                    ])
                    ->default('user')
                    ->label('Role')
                    ->required(), // Ensure it is required if neede
            ]);
    }
}
