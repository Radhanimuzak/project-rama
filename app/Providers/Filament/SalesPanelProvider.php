<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\RoleMiddleware;

class SalesPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->brandName('Marksys')
            ->id('sales')
            ->path('sales')
            ->login()
            ->colors([
                'primary' => [
                    50 => '#eff6ff',
                    100 => '#dbeafe',
                    200 => '#bfdbfe',
                    300 => '#93c5fd',
                    400 => '#60a5fa',
                    500 => '#1e3a8a',
                    600 => '#182f6f',
                    700 => '#122453',
                    800 => '#0c1938',
                    900 => '#060d1c',
                    950 => '#03060e',
                ],
            ])

            ->resources([
                // \App\Filament\Resources\UserResource::class,
                \App\Filament\Resources\Leadsdatasales\LeadsdataSalesResource::class,
                // Add more resources here as needed
            ])
            ->discoverPages(in: app_path('Filament/LeadsDataSales/Pages'), for: 'App\Filament\LeadsDataSales\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/LeadsDataSales/Widgets'), for: 'App\Filament\LeadsDataSales\Widgets')
            ->widgets([
                AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                
            ])
            ->authMiddleware([
                Authenticate::class,
                RoleMiddleware::class . ':sales',
            ]);
    }
}
