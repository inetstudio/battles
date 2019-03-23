<?php

namespace InetStudio\Battles\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class BattlesBindingsServiceProvider.
 */
class BattlesBindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Battles\Contracts\Events\Back\ModifyBattleEventContract' => 'InetStudio\Battles\Events\Back\ModifyBattleEvent',
        'InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesControllerContract' => 'InetStudio\Battles\Http\Controllers\Back\BattlesController',
        'InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesDataControllerContract' => 'InetStudio\Battles\Http\Controllers\Back\BattlesDataController',
        'InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesUtilityControllerContract' => 'InetStudio\Battles\Http\Controllers\Back\BattlesUtilityController',
        'InetStudio\Battles\Contracts\Http\Controllers\Front\BattlesVotesControllerContract' => 'InetStudio\Battles\Http\Controllers\Front\BattlesVotesController',
        'InetStudio\Battles\Contracts\Http\Requests\Back\SaveBattleRequestContract' => 'InetStudio\Battles\Http\Requests\Back\SaveBattleRequest',
        'InetStudio\Battles\Contracts\Http\Responses\Back\Battles\DestroyResponseContract' => 'InetStudio\Battles\Http\Responses\Back\Battles\DestroyResponse',
        'InetStudio\Battles\Contracts\Http\Responses\Back\Battles\FormResponseContract' => 'InetStudio\Battles\Http\Responses\Back\Battles\FormResponse',
        'InetStudio\Battles\Contracts\Http\Responses\Back\Battles\IndexResponseContract' => 'InetStudio\Battles\Http\Responses\Back\Battles\IndexResponse',
        'InetStudio\Battles\Contracts\Http\Responses\Back\Battles\SaveResponseContract' => 'InetStudio\Battles\Http\Responses\Back\Battles\SaveResponse',
        'InetStudio\Battles\Contracts\Http\Responses\Back\Battles\ShowResponseContract' => 'InetStudio\Battles\Http\Responses\Back\Battles\ShowResponse',
        'InetStudio\Battles\Contracts\Http\Responses\Back\Utility\SlugResponseContract' => 'InetStudio\Battles\Http\Responses\Back\Utility\SlugResponse',
        'InetStudio\Battles\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\Battles\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\Battles\Contracts\Http\Responses\Front\BattlesVotes\VoteResponseContract' => 'InetStudio\Battles\Http\Responses\Front\BattlesVotes\VoteResponse',
        'InetStudio\Battles\Contracts\Models\BattleModelContract' => 'InetStudio\Battles\Models\BattleModel',
        'InetStudio\Battles\Contracts\Models\BattleVoteModelContract' => 'InetStudio\Battles\Models\BattleVoteModel',
        'InetStudio\Battles\Contracts\Repositories\BattlesRepositoryContract' => 'InetStudio\Battles\Repositories\BattlesRepository',
        'InetStudio\Battles\Contracts\Repositories\BattlesVotesRepositoryContract' => 'InetStudio\Battles\Repositories\BattlesVotesRepository',
        'InetStudio\Battles\Contracts\Services\Back\BattlesDataTableServiceContract' => 'InetStudio\Battles\Services\Back\BattlesDataTableService',
        'InetStudio\Battles\Contracts\Services\Back\BattlesServiceContract' => 'InetStudio\Battles\Services\Back\BattlesService',
        'InetStudio\Battles\Contracts\Services\Front\BattlesServiceContract' => 'InetStudio\Battles\Services\Front\BattlesService',
        'InetStudio\Battles\Contracts\Services\Front\BattlesVotesServiceContract' => 'InetStudio\Battles\Services\Front\BattlesVotesService',
        'InetStudio\Battles\Contracts\Transformers\Back\BattleTransformerContract' => 'InetStudio\Battles\Transformers\Back\BattleTransformer',
        'InetStudio\Battles\Contracts\Transformers\Back\SuggestionTransformerContract' => 'InetStudio\Battles\Transformers\Back\SuggestionTransformer',
        'InetStudio\Battles\Contracts\Transformers\Front\BattlesFeedItemsTransformerContract' => 'InetStudio\Battles\Transformers\Front\BattlesFeedItemsTransformer',
        'InetStudio\Battles\Contracts\Transformers\Front\BattlesSiteMapTransformerContract' => 'InetStudio\Battles\Transformers\Front\BattlesSiteMapTransformer',
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
