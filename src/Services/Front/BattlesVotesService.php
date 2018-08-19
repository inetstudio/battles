<?php

namespace InetStudio\Battles\Services\Front;

use InetStudio\Battles\Contracts\Models\BattleVoteModelContract;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Cookie;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Services\Front\BattlesVotesServiceContract;

/**
 * Class BattlesVotesService.
 */
class BattlesVotesService implements BattlesVotesServiceContract
{
    /**
     * @var
     */
    public $repositories;

    /**
     * BattlesVotesService constructor.
     */
    public function __construct()
    {
        $this->repositories['battles'] = app()->make('InetStudio\Battles\Contracts\Repositories\BattlesRepositoryContract');
        $this->repositories['battlesVotes'] = app()->make('InetStudio\Battles\Contracts\Repositories\BattlesVotesRepositoryContract');
    }

    /**
     * Голосуем в битве.
     *
     * @param int $battleID
     * @param int $optionID
     *
     * @return BattleVoteModelContract|null
     */
    public function vote(int $battleID, int $optionID): ?BattleVoteModelContract
    {
        $battle = $this->repositories['battles']->getItemByID($battleID);

        $vote = (! $this->isVote($battle, null)) ? $this->repositories['battlesVotes']->save([
            'battle_id' => $battleID,
            'option_id' => $optionID,
            'user_id' => $this->getUserId(),
        ]) : null;

        return $vote;
    }

    /**
     * Голосовал ли пользователь в битве.
     *
     * @param BattleModelContract $battle
     * @param int|null $userID
     *
     * @return bool
     */
    public function isVote(BattleModelContract $battle, $userID): bool
    {
        $userId = $this->getUserId($userID);

        return $battle->votes()->where([
            'user_id' => $userId,
        ])->exists();
    }

    /**
     * Получить соотношение голосов.
     *
     * @param int $battleID
     *
     * @return mixed
     */
    public function getRatio(int $battleID)
    {
        $counts = $this->repositories['battlesVotes']->getItemsCountsByBattle($battleID);

        $allVotes = $counts->sum('total');

        $ratio = $counts->mapWithKeys(function ($item) use ($allVotes) {
            return [
                $item->option_id => ($allVotes > 0) ? round(($item->total/$allVotes)*100) : 0,
            ];
        });

        return $ratio;
    }

    /**
     * Получаем id пользователя.
     *
     * @param int|null $userId
     *
     * @return string
     */
    protected function getUserId($userId = null)
    {
        if (is_null($userId)) {
            $userId = $this->loggedInUserId();
        }

        if (! $userId) {
            $cookieData = request()->cookie('guest_user_hash');

            if ($cookieData) {
                return $cookieData;
            } else {
                $uuid = Uuid::uuid4()->toString();

                Cookie::queue('guest_user_hash', $uuid, 5256000);

                return $uuid;
            }
        }

        return $userId;
    }

    /**
     * Получаем id авторизованного пользователя.
     *
     * @return int
     */
    protected function loggedInUserId(): ?int
    {
        return auth()->id();
    }
}
