<?php

namespace InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource;

use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\EditResponseContract;

/**
 * Class EditResponse.
 */
class EditResponse extends BaseResponse implements EditResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * FormResponse constructor.
     *
     * @param  ItemsServiceContract  $resourceService
     */
    public function __construct(ItemsServiceContract $resourceService)
    {
        $this->resourceService = $resourceService;
        $this->view = 'admin.module.battles::back.pages.form';
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
        $id = $request->route('id', 0);

        $item = $this->resourceService->getItemById($id);

        return compact('item');
    }
}
