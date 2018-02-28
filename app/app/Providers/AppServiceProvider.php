<?php

namespace App\Providers;

use App\Contracts\PayableOrder;
use App\Contracts\PaySystemGateway;
use App\Models\Order;

use App\Services\Gateways\StripeGatewayService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->bind(PayableOrder::class, function () {
            return new Order();
        });
        $this->app->singleton(PaySystemGateway::class, function () {
            return new StripeGatewayService(config('services.stripe.secret'));
        });
    }
}
