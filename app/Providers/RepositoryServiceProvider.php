<?php 
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Repositories\ListingRepositoryInterface;
use App\Repositories\ListingRepository;

class RepositoryServiceProvider extends ServiceProvider 
{ 
   /** 
    * Register services. 
    * 
    * @return void  
    */ 
   public function register() 
   { 
       $this->app->bind(ListingRepositoryInterface::class, ListingRepository::class);
   }
}