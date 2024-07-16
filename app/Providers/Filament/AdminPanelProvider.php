<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Filament\Notifications\Livewire\DatabaseNotifications;
class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')            
            ->favicon(asset('images/favico.ico'))
            ->path('')
            ->login()
            // ->colors([
            //     // 'primary' => Color::Amber,
            //     'primary' => Color::Blue,
            //     'secondary' => Color::Gray,
            //     'accent' => Color::Purple,
            //     'info' => Color::Teal,
            //     'warning' => Color::Orange,
            //     'danger' => Color::Red,
            // ])
            ->colors([
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'primary' => Color::Indigo,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            
            // ->brandName('e-office')
            // ->brandlogo(asset('images/favico.ico'))
            ->font('Chakra Petch')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            // ->widgets([
            //     Widgets\AccountWidget::class,
            //     Widgets\FilamentInfoWidget::class,
            // ])
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
            ])
            ->databaseNotifications()            
            ->databaseNotificationsPolling('30s')
            ->plugins([
                FilamentBackgroundsPlugin::make()
                    ->remember(900)
                    ->imageProvider(
                        MyImages::make()
                            ->directory('images/backgrounds')
                    )
                    // ->showAttribution(false)
                    ,
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
                BreezyCore::make()->myProfile(
                    shouldRegisterUserMenu: true, // Sets the 'account' link in the panel User Menu (default = true)
                    shouldRegisterNavigation: true, // Adds a main navigation item for the My Profile page (default = false)
                    navigationGroup: 'Settings', // Sets the navigation group for the My Profile page (default = null)
                    hasAvatars: false, // Enables the avatar upload form component (default = false)
                    slug: 'my-profile' // Sets the slug for the profile page (default = 'my-profile')
                ),
                \TomatoPHP\FilamentUsers\FilamentUsersPlugin::make(),
                // \TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make(),
                // \TomatoPHP\FilamentTranslations\FilamentTranslationsPlugin::make()->allowGPTScan(),
                \TomatoPHP\FilamentTranslations\FilamentTranslationsSwitcherPlugin::make(),
                \TomatoPHP\FilamentSettingsHub\FilamentSettingsHubPlugin::make(),
            ]) 
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ;
    }
}
