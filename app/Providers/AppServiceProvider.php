<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Blade;
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
        Cashier::useCustomerModel(User::class);
        Cashier::calculateTaxes();

        Blade::if('subscribed', function (string $audience) {
            $user = auth()->user();
            return $user && $user->hasActivePlan($audience);
        });
    }
}
