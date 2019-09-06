<?php

namespace InetStudio\BattlesPackage\Battles\Http\Responses\Back\Utility;

use Cviebrock\EloquentSluggable\Services\SlugService;
use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Utility\SlugResponseContract;

/**
 * Class SlugResponse.
 */
class SlugResponse extends BaseResponse implements SlugResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $itemsService;

    /**
     * SlugResponse constructor.
     *
     * @param  ItemsServiceContract  $itemsService
     */
    public function __construct(ItemsServiceContract $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    /**
     * Prepare response data.
     *
     * @param $request
     *
     * @return array
     */
    protected function prepare($request): array
    {
        $id = (int) $request->get('id');
        $name = $request->get('name');

        $model = $this->itemsService->getItemById($id);

        $slug = ($name) ? SlugService::createSlug($model, 'slug', $name) : '';

        return [
            $slug,
        ];
    }
}
