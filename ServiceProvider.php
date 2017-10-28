<?php

namespace dam1r89\CodeQuality;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function register()
    {
        $this->commands([
            HooksInstallCommand::class,
            CodeFixCommand::class,
            CodeLintCommand::class,
        ]);
    }
}
