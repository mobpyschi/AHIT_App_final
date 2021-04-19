<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\View;

use App\Models\Configuration;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        paginator::useBootstrap();

        view()->composer('*', function(View $view) {
            $getFormatDate = Configuration::all();
            foreach ($getFormatDate as $key => $value) {
                $formatDates = $value->formatDate;
            }
            $view->with('formatDates', $formatDates);
        });
    }
}
