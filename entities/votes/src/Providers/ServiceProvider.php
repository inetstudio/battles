<?php

namespace InetStudio\BattlesPackage\Votes\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
    }

    /**
     * Регистрация команд.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            'InetStudio\BattlesPackage\Votes\Console\Commands\SetupCommand',
        ]);
    }

    /**
     * Регистрация ресурсов.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (Schema::hasTable('battles_votes')) {
            return;
        }

        $timestamp = date('Y_m_d_His', time());
        $this->publishes(
            [
                __DIR__.'/../../database/migrations/create_battles_votes_tables.php.stub'
                => database_path('migrations/'.$timestamp.'_create_battles_votes_tables.php'),
            ],
            'migrations'
        );
    }

    /**
     * Регистрация путей.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }
}
