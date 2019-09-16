<?php

namespace InetStudio\BattlesPackage\Battles\Providers;

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
        'InetStudio\BattlesPackage\Battles\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\BattlesPackage\Battles\Events\Back\ModifyItemEvent',
        'InetStudio\BattlesPackage\Battles\Contracts\Events\Front\ItemVoteResultChangedContract' => 'InetStudio\BattlesPackage\Battles\Events\Front\ItemVoteResultChanged',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\BattlesPackage\Battles\Http\Controllers\Back\DataController',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\BattlesPackage\Battles\Http\Controllers\Back\ResourceController',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\BattlesPackage\Battles\Http\Controllers\Back\UtilityController',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\BattlesPackage\Battles\Http\Requests\Back\SaveItemRequest',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\CreateResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource\CreateResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\EditResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource\EditResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Utility\SlugResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Utility\SlugResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\BattlesPackage\Battles\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract' => 'InetStudio\BattlesPackage\Battles\Models\BattleModel',
        'InetStudio\BattlesPackage\Battles\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\BattlesPackage\Battles\Services\Back\DataTables\IndexService',
        'InetStudio\BattlesPackage\Battles\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\BattlesPackage\Battles\Services\Back\ItemsService',
        'InetStudio\BattlesPackage\Battles\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\BattlesPackage\Battles\Services\Back\UtilityService',
        'InetStudio\BattlesPackage\Battles\Contracts\Services\Front\FeedsServiceContract' => 'InetStudio\BattlesPackage\Battles\Services\Front\FeedsService',
        'InetStudio\BattlesPackage\Battles\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\BattlesPackage\Battles\Services\Front\ItemsService',
        'InetStudio\BattlesPackage\Battles\Contracts\Services\Front\SitemapServiceContract' => 'InetStudio\BattlesPackage\Battles\Services\Front\SitemapService',
        'InetStudio\BattlesPackage\Battles\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\BattlesPackage\Battles\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\BattlesPackage\Battles\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\BattlesPackage\Battles\Transformers\Back\Utility\SuggestionTransformer',
        'InetStudio\BattlesPackage\Battles\Contracts\Transformers\Front\Sitemap\ItemTransformerContract' => 'InetStudio\BattlesPackage\Battles\Transformers\Front\Sitemap\ItemTransformer',
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
