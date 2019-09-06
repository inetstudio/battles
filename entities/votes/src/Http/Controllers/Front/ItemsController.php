<?php

namespace InetStudio\BattlesPackage\Votes\Http\Controllers\Front;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\BattlesPackage\Votes\Contracts\Http\Responses\Front\VoteResponseContract;
use InetStudio\BattlesPackage\Votes\Contracts\Http\Controllers\Front\ItemsControllerContract;

/**
 * Class ItemsController.
 */
class ItemsController extends Controller implements ItemsControllerContract
{
    /**
     * Голосование.
     *
     * @param Request $request
     * @param VoteResponseContract $response
     *
     * @return VoteResponseContract
     */
    public function vote(Request $request, VoteResponseContract $response): VoteResponseContract
    {
        return $response;
    }
}
