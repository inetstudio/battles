<?php

namespace InetStudio\Battles\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use InetStudio\Battles\Contracts\Http\Controllers\Front\BattlesVotesControllerContract;
use InetStudio\Battles\Contracts\Http\Responses\Front\BattlesVotes\VoteResponseContract;

/**
 * Class BattlesVotesController.
 */
class BattlesVotesController extends Controller implements BattlesVotesControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services;

    /**
     * BattlesVotesController constructor.
     */
    public function __construct()
    {
        $this->services['battlesVotes'] = app()->make('InetStudio\Battles\Contracts\Services\Front\BattlesVotesServiceContract');
    }

    /**
     * Сохранение объекта.
     *
     * @param int $battleID
     * @param int $optionID
     *
     * @return VoteResponseContract
     */
    public function vote(int $battleID, int $optionID): VoteResponseContract
    {
        $this->services['battlesVotes']->vote($battleID, $optionID);
        $ratio = $this->services['battlesVotes']->getRatio($battleID)->toArray();

        return app()->makeWith(VoteResponseContract::class, compact('ratio'));
    }
}
