<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureAgencyIsActive;
use App\Http\Middleware\EnsureIsAgentOrManager;
use App\Http\Middleware\SetLocale;
use App\Models\Agency;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AgencyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('agency')
            ->path('cabinet')
            ->viteTheme('resources/css/filament/agency/theme.css')
            ->login()
            ->authGuard('web')
            ->loginRouteSlug('login')
            ->brandName(fn () => Filament::getTenant()?->name ?? 'NidoReal')
            ->tenant(Agency::class, ownershipRelationship: 'agencies', slugAttribute: 'slug')
            ->tenantMiddleware([
                EnsureAgencyIsActive::class,
            ])
            ->discoverResources(in: app_path('Filament/Agency/Resources'), for: 'App\\Filament\\Agency\\Resources')
            ->discoverPages(in: app_path('Filament/Agency/Pages'), for: 'App\\Filament\\Agency\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->navigationItems([
                \Filament\Navigation\NavigationItem::make(fn () => __('cabinet.my_plan'))
                    ->icon('heroicon-o-credit-card')
                    ->url(fn () => route('billing.plans'))
                    ->visible(fn () => auth()->user()?->hasRole('agency_manager') ?? false)
                    ->sort(4),
            ])
            ->discoverWidgets(in: app_path('Filament/Agency/Widgets'), for: 'App\\Filament\\Agency\\Widgets')
            ->widgets([
                //
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                SetLocale::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->renderHook(
                'panels::user-menu.before',
                fn () => view('filament.locale-switcher')
            )
            ->authMiddleware([
                Authenticate::class,
                EnsureIsAgentOrManager::class,
            ]);
    }
}
