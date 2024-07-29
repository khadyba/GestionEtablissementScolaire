<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Cours;
use App\Models\Classe;
use App\Policies\CourePolicy;
use App\Policies\ClassePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        // 'App\Models\Classe' => 'App\Policies\ClassePolicy',

         Classe::class => ClassePolicy::class,
         Cours::class => CourePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::policy(Cours::class, CourePolicy::class);
        Gate::resource('classes', ClassePolicy::class);
    }
}
