<?php

namespace InetStudio\BattlesPackage\Battles\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\UtilityServiceContract;

/**
 * Class UtilityService.
 */
class UtilityService extends BaseService implements UtilityServiceContract
{
    /**
     * UtilityService constructor.
     *
     * @param  BattleModelContract  $model
     */
    public function __construct(BattleModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем подсказки.
     *
     * @param  string  $search
     *
     * @return Collection
     */
    public function getSuggestions(string $search): Collection
    {
        $items = $this->model::where(
            [
                ['title', 'LIKE', '%'.$search.'%'],
            ]
        )->get();

        return $items;
    }
}
