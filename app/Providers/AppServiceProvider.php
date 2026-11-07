<?php

namespace App\Providers;

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        // Bagikan data profil bank ke komponen navbar dan footer secara otomatis
        View::composer(['components.navbar', 'components.footer', 'layouts.app'], function ($view) {
            if (Schema::hasTable('company_profiles')) {
                $companyProfile = CompanyProfile::first();
                $view->with('companyProfile', $companyProfile);
            }
        });
    }
}