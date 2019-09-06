<?php

namespace InetStudio\BattlesPackage\Votes\Http\Responses\Front;

use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\BattlesPackage\Votes\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\BattlesPackage\Votes\Contracts\Http\Responses\Front\VoteResponseContract;

/**
 * Class VoteResponse.
 */
class VoteResponse extends BaseResponse implements VoteResponseContract
{
    /**
     * @var ItemsServiceContract
     */
    protected $itemsService;

    /**
     * VoteResponse constructor.
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
        $battleId = $request->route('battleId');
        $optionId = $request->route('optionId');

        $this->itemsService->vote($battleId, $optionId);
        $ratio = $this->itemsService->getRatio($battleId)->toArray();

        return [
            'success' => true,
            'ratio' => $ratio,
        ];
    }
}
