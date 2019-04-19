<?php

namespace InetStudio\Battles\Repositories;

use InetStudio\AdminPanel\Repositories\BaseRepository;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\AdminPanel\Repositories\Traits\SlugsRepositoryTrait;
use InetStudio\Products\Repositories\Traits\ProductsRepositoryTrait;
use InetStudio\Favorites\Repositories\Traits\FavoritesRepositoryTrait;
use InetStudio\Categories\Repositories\Traits\CategoriesRepositoryTrait;
use InetStudio\Battles\Contracts\Repositories\BattlesRepositoryContract;

/**
 * Class BattlesRepository.
 */
class BattlesRepository extends BaseRepository implements BattlesRepositoryContract
{
    use SlugsRepositoryTrait;
    use ProductsRepositoryTrait;
    use FavoritesRepositoryTrait;
    use CategoriesRepositoryTrait;

    /**
     * @var string 
     */
    protected $favoritesType = 'battle';

    /**
     * BattlesRepository constructor.
     *
     * @param BattleModelContract $model
     */
    public function __construct(BattleModelContract $model)
    {
        $this->model = $model;

        $this->defaultColumns = ['id', 'title', 'slug'];
        $this->relations = [
            'access' => function ($query) {
                $query->select(['accessable_id', 'accessable_type', 'field', 'access']);
            },

            'meta' => function ($query) {
                $query->select(['metable_id', 'metable_type', 'key', 'value']);
            },

            'media' => function ($query) {
                $query->select(['id', 'model_id', 'model_type', 'collection_name', 'file_name', 'disk', 'mime_type', 'custom_properties', 'responsive_images']);
            },

            'tags' => function ($query) {
                $query->select(['id', 'name', 'slug']);
            },

            'categories' => function ($query) {
                $query->select(['id', 'parent_id', 'name', 'slug', 'title', 'description'])->whereNotNull('parent_id');
            },

            'counters' => function ($query) {
                $query->select(['countable_id', 'countable_type', 'type', 'counter']);
            },

            'status' => function ($query) {
                $query->select(['id', 'name', 'alias', 'color_class']);
            },
        ];
    }
}
