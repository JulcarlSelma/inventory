<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Helpers\PageHelper;
use Illuminate\Support\Facades\Blade;

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
        View::share('pageHelper', app(PageHelper::class));
        Blade::component('components.card-component','card');
        Blade::component('components.modal-component','modal');
        Blade::component('components.button-component','button');
        Blade::component('components.category-form-component','category-form');
        Blade::component('components.category-delete-component','category-delete');
        Blade::component('components.product-form-component','product-form');
        Blade::component('components.product-delete-component','product-delete');
    }
}
