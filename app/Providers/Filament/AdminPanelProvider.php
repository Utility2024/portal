<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Pages\Auth\Login;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\ThemesPlugin;
use Filament\View\PanelsRenderHook;
use EightyNine\Reports\ReportsPlugin;
use Illuminate\Support\Facades\Blade;
use App\Filament\Widgets\LatestPatrol;
use Orion\FilamentBackup\BackupPlugin;
use EightyNine\Approvals\ApprovalPlugin;
use App\Filament\Widgets\CountMeasurement;
use App\Filament\Widgets\DailyPatrolChart;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Widgets\LatestMeasurement;
use App\Filament\Widgets\UserStatsOverview;
use Rmsramos\Activitylog\ActivitylogPlugin;
use App\Filament\Widgets\AUserStatsOverview;
use App\Filament\Widgets\CountDailyPatrol_1;
use App\Filament\Widgets\DailyPatrolChart_2;
use App\Filament\Widgets\DailyPatrolChart_3;
use App\Filament\Widgets\DailyPatrolChart_4;
use LaraZeus\DynamicDashboard\Models\Layout;
use LaraZeus\DynamicDashboard\Models\Columns;
use lockscreen\FilamentLockscreen\Lockscreen;
use pxlrbt\FilamentSpotlight\SpotlightPlugin;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Brickx\MaintenanceSwitch\MaintenanceSwitchPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use LaraZeus\DynamicDashboard\DynamicDashboardPlugin;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use TomatoPHP\FilamentAccounts\FilamentAccountsPlugin;
use BetterFuturesStudio\FilamentLocalLogins\LocalLogins;
use Filament\Http\Middleware\DisableBladeIconComponents;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups;
use CmsMulti\FilamentClearCache\FilamentClearCachePlugin;
use lockscreen\FilamentLockscreen\Http\Middleware\Locker;
use Shipu\WebInstaller\Middleware\RedirectIfNotInstalled;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use TomatoPHP\FilamentAccounts\FilamentAccountsSaaSPlugin;
use Edwink\FilamentUserActivity\FilamentUserActivityPlugin;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Tobiasla78\FilamentSimplePages\FilamentSimplePagesPlugin;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Tapp\FilamentAuthenticationLog\FilamentAuthenticationLogPlugin;
use Joaopaulolndev\FilamentGeneralSettings\FilamentGeneralSettingsPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;
use DutchCodingCompany\FilamentDeveloperLogins\FilamentDeveloperLoginsPlugin;
use JulioMotol\FilamentPasswordConfirmation\FilamentPasswordConfirmationPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->brandName('ESD PORTAL')
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                'Data master',
                'Data measurement',
                'Settings',
            ])
            ->default()
            ->id('esd')
            ->path('esd')
            ->login(Login::class)
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                AUserStatsOverview::class,
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
                CountMeasurement::class,
                LatestMeasurement::class,
                LatestPatrol::class,
                DailyPatrolChart::class,
                DailyPatrolChart_2::class,
                DailyPatrolChart_3::class,
                DailyPatrolChart_4::class,   
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
                SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                // FilamentShieldPlugin::make(),
                // ActivitylogPlugin::make(),
                //FilamentUserActivityPlugin::make(),
                new LocalLogins(),
                ThemesPlugin::make(),
                FilamentClearCachePlugin::make(),
                // ApprovalPlugin::make(),
                SpotlightPlugin::make(),
                FilamentApexChartsPlugin::make()
            ])
            ->authMiddleware([
                 RedirectIfNotInstalled::class, // <- Add this
            ]);
    }
}
