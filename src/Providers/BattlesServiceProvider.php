<?php

namespace InetStudio\Battles\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class BattlesServiceProvider.
 */
class BattlesServiceProvider extends ServiceProvider
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
        $this->registerViews();
        $this->registerObservers();
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    /**
     * Регистрация команд.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                'InetStudio\Battles\Console\Commands\SetupCommand',
                'InetStudio\Battles\Console\Commands\CreateFoldersCommand',
            ]);
        }
    }

    /**
     * Регистрация ресурсов.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../config/battles.php' => config_path('battles.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/filesystems.php', 'filesystems.disks'
        );

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateBattlesTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../../database/migrations/create_battles_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_battles_tables.php'),
                ], 'migrations');
            }
        }
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

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.battles');
    }

    /**
     * Регистрация наблюдателей.
     *
     * @return void
     */
    public function registerObservers(): void
    {
        $this->app->make('InetStudio\Battles\Contracts\Models\BattleModelContract')::observe($this->app->make('InetStudio\Battles\Contracts\Observers\BattleObserverContract'));
    }

    /**
     * Регистрация привязок, алиасов и сторонних провайдеров сервисов.
     *
     * @return void
     */
    protected function registerBindings(): void
    {
        // Controllers
        $this->app->bind('InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesControllerContract', 'InetStudio\Battles\Http\Controllers\Back\BattlesController');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesDataControllerContract', 'InetStudio\Battles\Http\Controllers\Back\BattlesDataController');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesUtilityControllerContract', 'InetStudio\Battles\Http\Controllers\Back\BattlesUtilityController');

        // Events
        $this->app->bind('InetStudio\Battles\Contracts\Events\Back\ModifyBattleEventContract', 'InetStudio\Battles\Events\Back\ModifyBattleEvent');

        // Models
        $this->app->bind('InetStudio\Battles\Contracts\Models\BattleModelContract', 'InetStudio\Battles\Models\BattleModel');

        // Observers
        $this->app->bind('InetStudio\Battles\Contracts\Observers\BattleObserverContract', 'InetStudio\Battles\Observers\BattleObserver');

        // Repositories
        $this->app->bind('InetStudio\Battles\Contracts\Repositories\BattlesRepositoryContract', 'InetStudio\Battles\Repositories\BattlesRepository');

        // Requests
        $this->app->bind('InetStudio\Battles\Contracts\Http\Requests\Back\SaveBattleRequestContract', 'InetStudio\Battles\Http\Requests\Back\SaveBattleRequest');

        // Responses
        $this->app->bind('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\DestroyResponseContract', 'InetStudio\Battles\Http\Responses\Back\Battles\DestroyResponse');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\FormResponseContract', 'InetStudio\Battles\Http\Responses\Back\Battles\FormResponse');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\IndexResponseContract', 'InetStudio\Battles\Http\Responses\Back\Battles\IndexResponse');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\SaveResponseContract', 'InetStudio\Battles\Http\Responses\Back\Battles\SaveResponse');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\ShowResponseContract', 'InetStudio\Battles\Http\Responses\Back\Battles\ShowResponse');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Responses\Back\Utility\SlugResponseContract', 'InetStudio\Battles\Http\Responses\Back\Utility\SlugResponse');
        $this->app->bind('InetStudio\Battles\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract', 'InetStudio\Battles\Http\Responses\Back\Utility\SuggestionsResponse');

        // Services
        $this->app->bind('InetStudio\Battles\Contracts\Services\Back\BattlesDataTableServiceContract', 'InetStudio\Battles\Services\Back\BattlesDataTableService');
        $this->app->bind('InetStudio\Battles\Contracts\Services\Back\BattlesObserverServiceContract', 'InetStudio\Battles\Services\Back\BattlesObserverService');
        $this->app->bind('InetStudio\Battles\Contracts\Services\Back\BattlesServiceContract', 'InetStudio\Battles\Services\Back\BattlesService');
        $this->app->bind('InetStudio\Battles\Contracts\Services\Front\BattlesServiceContract', 'InetStudio\Battles\Services\Front\BattlesService');

        // Transformers
        $this->app->bind('InetStudio\Battles\Contracts\Transformers\Back\BattleTransformerContract', 'InetStudio\Battles\Transformers\Back\BattleTransformer');
        $this->app->bind('InetStudio\Battles\Contracts\Transformers\Back\SuggestionTransformerContract', 'InetStudio\Battles\Transformers\Back\SuggestionTransformer');
        $this->app->bind('InetStudio\Battles\Contracts\Transformers\Front\BattlesFeedItemsTransformerContract', 'InetStudio\Battles\Transformers\Front\BattlesFeedItemsTransformer');
        $this->app->bind('InetStudio\Battles\Contracts\Transformers\Front\BattlesSiteMapTransformerContract', 'InetStudio\Battles\Transformers\Front\BattlesSiteMapTransformer');
    }
}
