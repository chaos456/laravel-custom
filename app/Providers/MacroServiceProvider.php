<?php

namespace App\Providers;

use App\Support\BuilderMacro;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

/**
 * 宏扩展
 */
class MacroServiceProvider extends ServiceProvider
{


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        $builderMacro = new BuilderMacro();

        Builder::mixin($builderMacro);
    }
}
