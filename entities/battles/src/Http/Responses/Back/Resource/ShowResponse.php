<?php

namespace InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource;

use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\FeedbackPackage\Feedback\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse extends BaseResponse implements ShowResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $resourceService;

    /**
     * ShowResponse constructor.
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

        $item = $this->resourceService->getItemById($id);

        return $item->toArray();
    }
}
