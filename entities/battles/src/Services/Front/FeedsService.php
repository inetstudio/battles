<?php

namespace InetStudio\BattlesPackage\Battles\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Front\FeedsServiceContract;

/**
 * Class FeedsService.
 */
class FeedsService extends BaseService implements FeedsServiceContract
{
    /**
     * FeedsService constructor.
     *
     * @param  BattleModelContract  $model
     */
    public function __construct(BattleModelContract $model)
    {
        parent::__construct($model);
    }
}
