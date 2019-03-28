<?php

namespace App\Providers;

use App\Models\Company;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Blade::component('components.task_status_stats', 'taskStatusStats');
        Blade::component('components.year_month_filter', 'yearMonthFilter');
        Blade::component('components.task', 'task');
        Blade::component('components.show_errors', 'errors');
    }
}
