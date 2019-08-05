<?php

namespace InetStudio\Battles\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesDataControllerContract;

/**
 * Class BattlesDataController.
 */
class BattlesDataController extends Controller implements BattlesDataControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services;

    /**
     * BattlesController constructor.
     */
    public function __construct()
    {
        $this->services['dataTables'] = app()->make('InetStudio\Battles\Contracts\Services\Back\BattlesDataTableServiceContract');
    }

    /**
     * Получаем данные для отображения в таблице.
     *
     * @return mixed
     */
    public function data()
    {
        return $this->services['dataTables']->ajax();
    }
}
