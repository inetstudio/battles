<?php

namespace InetStudio\BattlesPackage\Battles\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Controllers\Back\DataControllerContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  Request  $request
     * @param  GetIndexDataResponseContract  $response
     *
     * @return GetIndexDataResponseContract
     */
    public function getIndexData(Request $request, GetIndexDataResponseContract $response): GetIndexDataResponseContract
    {
        return $response;
    }
}
