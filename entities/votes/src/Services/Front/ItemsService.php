<?php

namespace InetStudio\BattlesPackage\Votes\Services\Front;

use Illuminate\Support\Facades\DB;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\BattlesPackage\Votes\Contracts\Models\VoteModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Votes\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Front\ItemsServiceContract as BattlesServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * @var BattlesServiceContract
     */
    protected $battlesService;

    /**
     * ItemsService constructor.
     *
     * @param  BattlesServiceContract  $battlesService
     * @param  VoteModelContract  $model
     */
    public function __construct(BattlesServiceContract $battlesService, VoteModelContract $model)
    {
        parent::__construct($model);

        $this->battlesService = $battlesService;
    }

    /**
     * Голосуем в битве.
     *
     * @param  int  $battleId
     * @param  int  $optionId
     *
     * @return VoteModelContract|null
     *
     * @throws BindingResolutionException
     */
    public function vote(int $battleId, int $optionId): ?VoteModelContract
    {
        $battle = $this->battlesService->getItemById($battleId);
        $isVote = $this->isVote($battle);

        $vote = (! $isVote['result'])
            ? $this->saveModel(
                [
                    'battle_id' => $battleId,
                    'option_id' => $optionId,
                    'user_id' => $isVote['userId'],
                ]
            )
            : null;

        return $vote;
    }

    /**
     * Голосовал ли пользователь в битве.
     *
     * @param  BattleModelContract  $battle
     *
     * @return bool
     *
     * @throws BindingResolutionException
     */
    public function isVote(BattleModelContract $battle): bool
    {
        $usersService = app()->make('InetStudio\ACL\Users\Contracts\Services\Front\UsersServiceContract');
        $userId = $usersService->getUserIDOrHash();

        $result = $battle->votes()->where(
            [
                'user_id' => $userId,
            ]
        )->exists();

        return compact('userId', 'result');
    }

    /**
     * Получить соотношение голосов.
     *
     * @param int $battleId
     *
     * @return mixed
     */
    public function getRatio(int $battleId)
    {
        $counts = $this->getItemsCounts($battleId);

        $total = $counts->sum('total');

        $ratio = $counts->mapWithKeys(function ($item) use ($total) {
            return [
                $item['option_id'] => ($total > 0) ? round(($item['total'] / $total) * 100) : 0,
            ];
        });

        return $ratio;
    }

    /**
     * Получаем счетчики голосов.
     *
     * @param int $battleId
     *
     * @return mixed
     */
    public function getItemsCounts(int $battleId)
    {
        $builder = $this->model::groupBy('option_id')
            ->select('option_id', DB::raw('count(*) as total'))
            ->where('battle_id', '=', $battleId);

        return $builder->get();
    }
}
