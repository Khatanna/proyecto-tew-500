<?php

namespace App\Providers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
    App::bind(Authenticatable::class, function() {
      return auth()->user();
    });

    Paginator::defaultView('vendor.pagination.bootstrap-4');
  }
}
