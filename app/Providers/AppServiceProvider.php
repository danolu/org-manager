<?php

namespace App\Providers;

use App\Models\Setting;
use Auth;
use Illuminate\Support\ServiceProvider;
use Schema;
use View;

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
        Schema::defaultStringLength(125);
        $data['k'] = 0;
        view::share($data);

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $view->with('user', $user);
            }
            $settings = Setting::first();
            $view->with('settings', $settings);
        });
    }
}
