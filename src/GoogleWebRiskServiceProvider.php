<?php

namespace Harrisonratcliffe\LaravelGoogleWebRisk;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class GoogleWebRiskServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
             __DIR__.'/Config/google-web-risk.php' => config_path('google-web-risk.php'),
         ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerGoogleWebRisk();
        $this->mergeConfigFrom( __DIR__.'/Config/google-web-risk.php', 'googlewebrisk');
    }

    private function registerGoogleWebRisk()
    {
        $this->app->bind('googlewebrisk',function($app){
            return new GoogleWebRisk($app);
        });
    }
}
