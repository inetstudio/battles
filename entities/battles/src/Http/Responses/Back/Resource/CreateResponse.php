<?php

namespace InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource;

use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\CreateResponseContract;

/**
 * Class CreateResponse.
 */
class CreateResponse extends BaseResponse implements CreateResponseContract
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
        $item = $this->resourceService->getItemById();

        return compact('item');
    }
}
