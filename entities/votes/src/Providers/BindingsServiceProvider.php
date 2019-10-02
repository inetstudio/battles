<?php

namespace InetStudio\BattlesPackage\Votes\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\BattlesPackage\Votes\Contracts\Http\Controllers\Front\ItemsControllerContract' => 'InetStudio\BattlesPackage\Votes\Http\Controllers\Front\ItemsController',
        'InetStudio\BattlesPackage\Votes\Contracts\Http\Responses\Front\VoteResponseContract' => 'InetStudio\BattlesPackage\Votes\Http\Responses\Front\VoteResponse',
        'InetStudio\BattlesPackage\Votes\Contracts\Models\VoteModelContract' => 'InetStudio\BattlesPackage\Votes\Models\VoteModel',
        'InetStudio\BattlesPackage\Votes\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\BattlesPackage\Votes\Services\Front\ItemsService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
