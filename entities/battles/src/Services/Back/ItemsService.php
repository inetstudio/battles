<?php

namespace InetStudio\BattlesPackage\Battles\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  BattleModelContract  $model
     */
    public function __construct(BattleModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return BattleModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): BattleModelContract
    {
        $action = ($id) ? 'отредактирована' : 'создана';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        $metaData = Arr::get($data, 'meta', []);
        app()->make('InetStudio\MetaPackage\Meta\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject($metaData, $item);

        $images = (config('battles.images.conversions.'.$item->material_type)) ? array_keys(config('battles.images.conversions.'.$item->material_type)) : [];
        app()->make('InetStudio\Uploads\Contracts\Services\Back\ImagesServiceContract')
            ->attachToObject(request(), $item, $images, 'battles', $item->material_type);

        $tagsData = Arr::get($data, 'tags', []);
        app()->make('InetStudio\TagsPackage\Tags\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject($tagsData, $item);

        $categoriesData = Arr::get($data, 'categories', []);
        app()->make('InetStudio\CategoriesPackage\Categories\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject($categoriesData, $item);

        $fieldsAccessData = Arr::get($data, 'access.fields', []);
        app()->make('InetStudio\AccessPackage\Fields\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject($fieldsAccessData, $item);

        app()->make('InetStudio\WidgetsPackage\Widgets\Contracts\Services\Back\ItemsServiceContract')
            ->attachToObject(request(), $item);

        $item->searchable();

        event(
            app()->makeWith(
                'InetStudio\BattlesPackage\Battles\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Битва «'.$item->title.'» успешно '.$action);

        return $item;
    }

    /**
     * Возвращаем статистику битв по статусу.
     *
     * @return mixed
     */
    public function getItemsStatisticByStatus()
    {
        $items = $this->model::buildQuery(
                [
                    'relations' => ['status'],
                ]
            )
            ->select(['status_id', DB::raw('count(*) as total')])
            ->groupBy('status_id')
            ->get();

        return $items;
    }
}
