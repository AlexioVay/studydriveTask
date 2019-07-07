<?php

namespace App\Providers;

use App\Project;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $project = new Project();
        $project->initialize();
        view()->share('project', $project->index());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
