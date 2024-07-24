<?php

namespace App\Providers;

use App\Services\SiteSettingsService;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\PropertyBooking;
use Spatie\Analytics\AnalyticsFacade;
use Spatie\GoogleTagManager\GoogleTagManagerFacade;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SiteSettingsService::class, function ($app) {
            return new SiteSettingsService();
        });
    }

    public function boot()
    {
        Livewire::component('property-booking', PropertyBooking::class);
        Livewire::component('valuation-booking', \App\Http\Livewire\ValuationBooking::class);

        // Register and boot Analytics and Google Tag Manager
        AnalyticsFacade::registerBindings();
        GoogleTagManagerFacade::enable();
    }
}