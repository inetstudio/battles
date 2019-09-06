<?php

namespace InetStudio\BattlesPackage\Battles\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\AdminPanel\Base\Services\Traits\SlugsServiceTrait;
use InetStudio\Favorites\Services\Front\Traits\FavoritesServiceTrait;
use InetStudio\TagsPackage\Tags\Services\Front\Traits\TagsServiceTrait;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Front\ItemsServiceContract;
use InetStudio\CategoriesPackage\Categories\Services\Front\Traits\CategoriesServiceTrait;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    use TagsServiceTrait;
    use SlugsServiceTrait;
    use FavoritesServiceTrait;
    use CategoriesServiceTrait;

    /**
     * @var string
     */
    protected $favoritesType = 'battle';

    /**
     * ItemsService constructor.
     *
     * @param  BattleModelContract  $model
     */
    public function __construct(BattleModelContract $model)
    {
        parent::__construct($model);
    }
}
