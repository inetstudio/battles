<?php

namespace InetStudio\Battles\Repositories;

use Illuminate\Support\Facades\DB;
use InetStudio\AdminPanel\Repositories\BaseRepository;
use InetStudio\Battles\Contracts\Models\BattleVoteModelContract;
use InetStudio\Battles\Contracts\Repositories\BattlesVotesRepositoryContract;

/**
 * Class BattlesVotesRepository.
 */
class BattlesVotesRepository extends BaseRepository implements BattlesVotesRepositoryContract
{
    /**
     * BattlesVotesRepository constructor.
     *
     * @param BattleVoteModelContract $model
     */
    public function __construct(BattleVoteModelContract $model)
    {
        $this->model = $model;

        $this->defaultColumns = ['id', 'battle_id', 'option_id', 'user_id'];
        $this->relations = [
            'battle' => function ($query) {
                $query->select(['id', 'title', 'slug']);
            },
        ];
    }

    /**
     * Получаем счетчики голосов.
     *
     * @param int $battleID
     *
     * @return mixed
     */
    public function getItemsCountsByBattle(int $battleID)
    {
        $builder = $this->model::groupBy('option_id')
            ->select('option_id', DB::raw('count(*) as total'))
            ->where('battle_id', '=', $battleID);

        return $builder->get();
    }
}
