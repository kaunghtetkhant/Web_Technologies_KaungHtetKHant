<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;


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
        Model::unguard();

        Filament::serving(function (): void {
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Category'),
                NavigationGroup::make()
                    ->label('Product List'),
                NavigationGroup::make()
                    ->label('Merchants'),
                NavigationGroup::make()
                    ->label('Reports'),

            ]);
        });


        if ($this->app->environment('production') || $this->app->environment('staging')) {
            URL::forceScheme('https');
        }



    }
}
