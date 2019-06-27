<?php

namespace App\Providers;

use App\Model\Ticket\Ticket;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Localization Carbon
        \Carbon\Carbon::setLocale(config('app.locale'));

        // Default string length
        Schema::defaultStringLength(191);

        \View::composer([
            'home.index',
            'summary.index',
            'tickets.index',
            'tickets.edit',
            'users.index',
            'users.edit',
            'help.index'
        ], function($view) {
            $view->with('openTickets', Ticket::where('status', 'open')->count());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
