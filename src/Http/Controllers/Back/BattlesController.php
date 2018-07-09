<?php

namespace InetStudio\Battles\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\Battles\Contracts\Http\Requests\Back\SaveBattleRequestContract;
use InetStudio\Battles\Contracts\Http\Controllers\Back\BattlesControllerContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Battles\FormResponseContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Battles\SaveResponseContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Battles\ShowResponseContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Battles\IndexResponseContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Battles\DestroyResponseContract;

/**
 * Class BattlesController.
 */
class BattlesController extends Controller implements BattlesControllerContract
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
        $this->services['battles'] = app()->make('InetStudio\Battles\Contracts\Services\Back\BattlesServiceContract');
        $this->services['dataTables'] = app()->make('InetStudio\Battles\Contracts\Services\Back\BattlesDataTableServiceContract');
    }

    /**
     * Список объектов.
     *
     * @return IndexResponseContract
     */
    public function index(): IndexResponseContract
    {
        $table = $this->services['dataTables']->html();

        return app()->makeWith('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\IndexResponseContract', [
            'data' => compact('table'),
        ]);
    }

    /**
     * Получение объекта.
     *
     * @param int $id
     *
     * @return ShowResponseContract
     */
    public function show(int $id = 0): ShowResponseContract
    {
        $item = $this->services['battles']->getBattleObject($id);

        return app()->makeWith(ShowResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Создание объекта.
     *
     * @return FormResponseContract
     */
    public function create(): FormResponseContract
    {
        $item = $this->services['battles']->getBattleObject();

        return app()->makeWith('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\FormResponseContract', [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param SaveBattleRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(SaveBattleRequestContract $request): SaveResponseContract
    {
        return $this->save($request);
    }

    /**
     * Редактирование объекта.
     *
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(int $id = 0): FormResponseContract
    {
        $item = $this->services['battles']->getBattleObject($id);

        return app()->makeWith('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\FormResponseContract', [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param SaveBattleRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(SaveBattleRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param SaveBattleRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    private function save(SaveBattleRequestContract $request, int $id = 0): SaveResponseContract
    {
        $item = $this->services['battles']->save($request, $id);

        return app()->makeWith('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\SaveResponseContract', [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(int $id = 0): DestroyResponseContract
    {
        $result = $this->services['battles']->destroy($id);

        return app()->makeWith('InetStudio\Battles\Contracts\Http\Responses\Back\Battles\DestroyResponseContract', [
            'result' => (!! $result),
        ]);
    }
}
