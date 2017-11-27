<?php

namespace App\Providers;

use App\Completter;
use App\Order;
use App\Policies\CompletterPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReportPolicy;
use App\Policies\SpaletterPolicy;
use App\Report;
use App\Spaletter;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Completter::class => CompletterPolicy::class,
        Spaletter::class => SpaletterPolicy::class,
        Order::class => OrderPolicy::class,
        Report::class => ReportPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
