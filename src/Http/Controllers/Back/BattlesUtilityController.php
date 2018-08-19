<?php

namespace InetStudio\Battles\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;
use InetStudio\Battles\Contracts\Http\Responses\Back\Utility\SlugResponseContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;
use InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesUtilityControllerContract;

/**
 * Class BattlesUtilityController.
 */
class BattlesUtilityController extends Controller implements BattlesUtilityControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services;

    /**
     * BattlesUtilityController constructor.
     */
    public function __construct()
    {
        $this->services['battles'] = app()->make('InetStudio\Battles\Contracts\Services\Back\BattlesServiceContract');
    }

    /**
     * Получаем slug для модели по строке.
     *
     * @param Request $request
     *
     * @return SlugResponseContract
     */
    public function getSlug(Request $request): SlugResponseContract
    {
        $name = $request->get('name');
        $model = app()->make('InetStudio\Battles\Contracts\Models\BattleModelContract');

        $slug = ($name) ? SlugService::createSlug($model, 'slug', $name) : '';

        return app()->makeWith(SlugResponseContract::class, [
            'slug' => $slug,
        ]);
    }

    /**
     * Возвращаем статьи для поля.
     *
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(Request $request): SuggestionsResponseContract
    {
        $search = $request->get('q');
        $type = $request->get('type');

        $data = $this->services['battles']->getSuggestions($search, $type);

        return app()->makeWith(SuggestionsResponseContract::class, [
            'suggestions' => $data,
        ]);
    }
}
