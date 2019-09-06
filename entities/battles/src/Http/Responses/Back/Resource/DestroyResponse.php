<?php

namespace InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource;

use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class DestroyResponse.
 */
class DestroyResponse extends BaseResponse implements DestroyResponseContract
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
        $id = $request->route('id');

        $result = $this->resourceService->destroy($id);

        return [
            'success' => $result,
        ];
    }
}
