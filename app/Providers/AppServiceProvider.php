<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use BezhanSalleh\PanelSwitch\PanelSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Health::checks([
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
        ]);

        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $user = auth()->user();
        
            $icons = [];
            $labels = [];
        
            if ($user) {
                if ($user->hasAnyRole(['super_admin', 'manager', 'spv', 'panel_user'])) {
                    $icons['esd'] = 'heroicon-o-bolt';
                    $labels['esd'] = 'ESD';
                }
        
                if ($user->hasAnyRole(['super_admin', 'manager', 'spv', 'panel_user'])) {
                    $icons['utility'] = 'heroicon-o-adjustments-vertical';
                    $labels['utility'] = 'Utility';
                }
        
                if ($user->hasAnyRole(['super_admin', 'manager', 'spv', 'panel_user'])) {
                    $icons['admin'] = 'heroicon-o-user';
                    $labels['admin'] = 'Admin';
                }

                if ($user->hasAnyRole(['super_admin', 'manager', 'spv','panel_user'])) {
                    $icons['stock'] = 'heroicon-o-inbox-stack';
                    $labels['stock'] = 'Stock Material';
                }
            }
            
            $panelSwitch
                //->modalWidth('sm')
                ->modalHeading('Switch Portal')
                ->slideOver()
                ->icons($icons)
                ->iconSize(33)
                ->labels($labels)
                ->visible(fn (): bool => !empty($icons)); // Show the panel only if there are icons to display
        });
        
        
        
    }
}
