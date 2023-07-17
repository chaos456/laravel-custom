<?php

namespace App\Providers;

use App\Support\BuilderMacro;
use App\Support\Context;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
        //
    }

    public function boot()
    {
        Carbon::setLocale('zh');
        Builder::mixin(new BuilderMacro());
    }
}
