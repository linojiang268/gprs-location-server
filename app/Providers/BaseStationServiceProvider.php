<?php
namespace GL\Providers;

use Illuminate\Support\ServiceProvider;

class BaseStationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \GL\Models\BaseStation\ChinaMobileRepository::class,
            \GL\Support\Repositories\BaseStation\ChinaMobileRepository::class

        );
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            \GL\Models\BaseStation\ChinaMobileRepository::class,
        ];
    }
}
