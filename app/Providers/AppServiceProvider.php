<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
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

        // Logintud maxima de un string
        Schema::defaultStringLength(191);

		// Variable que contiene el numero de tickets abiertos
        \View::composer([
            'home.index',
            'summary.index',
            'tickets.index',
            'tickets.edit',
            'users.index',
            'users.edit',
            'help.index'
        ], function($view) {
            if (auth()->user()->role == 'user') {
                $view->with('openTickets', Ticket::where('status', 'open')
                    ->where('user_id', auth()->id())
                    ->count()
                );
            }
            else {
                $view->with('openTickets', Ticket::where('status', 'open')->count());
            }
		});

		// Para validar fecha con multiples formatos
		Validator::extend('date_format_multi', function($attribute, $value, $formats)
		{
			foreach($formats as $format) {
				$parsed = date_parse_from_format($format, $value);
				if ($parsed['error_count'] === 0 && $parsed['warning_count'] === 0) {
					return true;
				}
			}
			return false;
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
