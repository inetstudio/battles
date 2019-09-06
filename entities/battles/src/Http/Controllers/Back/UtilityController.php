<?php

namespace InetStudio\BattlesPackage\Battles\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Utility\SlugResponseContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class UtilityController.
 */
class UtilityController extends Controller implements UtilityControllerContract
{
    /**
     * Получаем slug для модели по строке.
     *
     * @param Request $request
     * @param SlugResponseContract $response
     *
     * @return SlugResponseContract
     */
    public function getSlug(Request $request, SlugResponseContract $response): SlugResponseContract
    {
        return $response;
    }

    /**
     * Возвращаем статьи для поля.
     *
     * @param Request $request
     * @param SuggestionsResponseContract $response
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(Request $request, SuggestionsResponseContract $response): SuggestionsResponseContract
    {
        return $response;
    }
}
