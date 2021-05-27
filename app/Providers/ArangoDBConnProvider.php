<?php 
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Helpers\ArangoDBConn;
use App\Helpers\ArangoDBConnInterface;
class ArangoDBConnProvider extends ServiceProvider
{
    protected $defer = true;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }
    public function register()
    {
        $this->app->bind('App\Helpers\ArangoDBConnInterface', function(){

            return new ArangoDBConn();

        });
    }
    public function provides()
    {
        return ['App\Helpers\ArangoDBConnInterface'];
    }
 
}