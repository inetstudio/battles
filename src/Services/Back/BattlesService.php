<?php

namespace InetStudio\Battles\Services\Back;

use League\Fractal\Manager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Services\Back\BattlesServiceContract;
use InetStudio\Battles\Contracts\Http\Requests\Back\SaveBattleRequestContract;

/**
 * Class BattlesService.
 */
class BattlesService implements BattlesServiceContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services = [];

    /**
     * @var
     */
    public $repository;

    /**
     * BattlesService constructor.
     */
    public function __construct()
    {
        $this->services['meta'] = app()->make('InetStudio\Meta\Contracts\Services\Back\MetaServiceContract');
        $this->services['uploads'] = app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract');
        $this->services['tags'] = app()->make('InetStudio\Tags\Contracts\Services\Back\TagsServiceContract');
        $this->services['categories'] = app()->make('InetStudio\Categories\Contracts\Services\Back\CategoriesServiceContract');
        $this->services['access'] = app()->make('InetStudio\Access\Contracts\Services\Back\AccessServiceContract');
        $this->services['widgets'] = app()->make('InetStudio\Widgets\Contracts\Services\Back\WidgetsServiceContract');

        $this->repository = app()->make('InetStudio\Battles\Contracts\Repositories\BattlesRepositoryContract');
    }

    /**
     * Возвращаем объект модели.
     *
     * @param int $id
     *
     * @return BattleModelContract
     */
    public function getBattleObject(int $id = 0)
    {
        return $this->repository->getItemByID($id);
    }

    /**
     * Получаем объекты по списку id.
     *
     * @param array|int $ids
     * @param array $params
     *
     * @return mixed
     */
    public function getBattlesByIDs($ids, array $params = [])
    {
        return $this->repository->getItemsByIDs($ids, $params);
    }

    /**
     * Сохраняем модель.
     *
     * @param SaveBattleRequestContract $request
     * @param int $id
     *
     * @return BattleModelContract
     */
    public function save(SaveBattleRequestContract $request, int $id): BattleModelContract
    {
        $action = ($id) ? 'отредактирована' : 'создана';
        $item = $this->repository->save($request->only($this->repository->getModel()->getFillable()), $id);

        $this->services['meta']->attachToObject($request, $item);

        $images = (config('battles.images.conversions.'.$item->material_type)) ? array_keys(config('battles.images.conversions.'.$item->material_type)) : [];
        $this->services['uploads']->attachToObject($request, $item, $images, 'battles', $item->material_type);

        $this->services['tags']->attachToObject($request, $item);
        $this->services['categories']->attachToObject($request, $item);
        $this->services['access']->attachToObject($request, $item);
        $this->services['widgets']->attachToObject($request, $item);

        $item->searchable();

        event(app()->makeWith('InetStudio\Battles\Contracts\Events\Back\ModifyBattleEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Битва «'.$item->title.'» успешно '.$action);

        return $item;
    }

    /**
     * Удаляем модель.
     *
     * @param int $id
     *
     * @return bool|null
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->destroy($id);
    }

    /**
     * Возвращаем подсказки.
     *
     * @param string $search
     * @param $type
     *
     * @return array
     */
    public function getSuggestions(string $search, $type): array
    {
        $items = $this->repository->searchItems([['title', 'LIKE', '%'.$search.'%']]);

        $resource = (app()->makeWith('InetStudio\Battles\Contracts\Transformers\Back\SuggestionTransformerContract', [
            'type' => $type,
        ]))->transformCollection($items);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();

        if ($type && $type == 'autocomplete') {
            $data['suggestions'] = $transformation['data'];
        } else {
            $data['items'] = $transformation['data'];
        }

        return $data;
    }

    /**
     * Возвращаем статистику битв по статусу.
     *
     * @return mixed
     */
    public function getBattlesStatisticByStatus()
    {
        $battles = $this->repository->getItemsQuery([
                'columns' => ['status_id', DB::raw('count(*) as total')],
                'relations' => ['status'],
            ])
            ->groupBy('status_id')
            ->get();

        return $battles;
    }
}
