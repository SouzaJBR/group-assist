<?php

namespace App\Providers;

use App\Services\UserTempStorage;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->app->singleton('user.storage.temp', UserTempStorage::class);
    }

    public function register()
    {
        parent::register();
        require_once __DIR__ . '/../Helper/session_helper.php';
    }
}
