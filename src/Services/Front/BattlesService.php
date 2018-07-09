<?php

namespace InetStudio\Battles\Services\Front;

use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\Battles\Contracts\Services\Front\BattlesServiceContract;

/**
 * Class BattlesService.
 */
class BattlesService implements BattlesServiceContract
{
    /**
     * @var
     */
    public $repository;

    /**
     * BattlesService constructor.
     */
    public function __construct()
    {
        $this->repository = app()->make('InetStudio\Battles\Contracts\Repositories\BattlesRepositoryContract');
    }

    /**
     * Получаем объект по id.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getBattleById(int $id = 0)
    {
        return $this->repository->getItemByID($id);
    }

    /**
     * Получаем объекты по id.
     *
     * @param $ids
     * @param array $extColumns
     * @param array $with
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getBattlesByIDs($ids, array $extColumns = [], array $with = [], bool $returnBuilder = false)
    {
        return $this->repository->getItemsByIDs($ids, $extColumns, $with, $returnBuilder);
    }

    /**
     * Получаем объект по slug.
     *
     * @param string $slug
     * @param array $extColumns
     * @param array $with
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getBattleBySlug(string $slug, array $extColumns = [], array $with = [], bool $returnBuilder = false)
    {
        return $this->repository->getItemBySlug($slug, $extColumns, $with, $returnBuilder);
    }

    /**
     * Получаем объекты по тегу.
     *
     * @param string $tagSlug
     * @param array $extColumns
     * @param array $with
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getBattlesByTag(string $tagSlug, array $extColumns = [], array $with = [], bool $returnBuilder = false)
    {
        return $this->repository->getItemsByTag($tagSlug, $extColumns, $with, $returnBuilder);
    }

    /**
     * Получаем объекты по категории.
     *
     * @param string $categorySlug
     * @param array $extColumns
     * @param array $with
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getBattlesByCategory(string $categorySlug, array $extColumns = [], array $with = [], bool $returnBuilder = false)
    {
        return $this->repository->getItemsByCategory($categorySlug, $extColumns, $with, $returnBuilder);
    }

    /**
     * Получаем объекты из категорий.
     *
     * @param $categories
     * @param array $extColumns
     * @param array $with
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getBattlesFromCategories($categories, array $extColumns = [], array $with = [], bool $returnBuilder = false)
    {
        return $this->repository->getItemsFromCategories($categories, $extColumns, $with, $returnBuilder);
    }

    /**
     * Получаем сохраненные объекты пользователя.
     *
     * @param int $userID
     * @param array $extColumns
     * @param array $with
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getBattlesFavoritedByUser(int $userID, array $extColumns = [], array $with = [], bool $returnBuilder = false)
    {
        return $this->repository->getItemsFavoritedByUser($userID, $extColumns, $with, $returnBuilder);
    }

    /**
     * Получаем все объекты.
     *
     * @param array $extColumns
     * @param array $with
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getAllBattles(array $extColumns = [], array $with = [], bool $returnBuilder = false)
    {
        return $this->repository->getAllItems($extColumns, $with, $returnBuilder);
    }

    /**
     * Получаем информацию по ингредиентам для фида.
     *
     * @return array
     */
    public function getFeedItems(): array
    {
        $items = $this->repository->getAllItems(['title', 'description', 'content', 'publish_date'], ['categories'], true)
            ->whereNotNull('publish_date')
            ->orderBy('publish_date', 'desc')
            ->limit(500)
            ->get();

        $resource = app()->make('InetStudio\Battles\Contracts\Transformers\Front\BattlesFeedItemsTransformerContract')
            ->transformCollection($items);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();

        return $transformation['data'];
    }

    /**
     * Получаем информацию по ингредиентам для карты сайта.
     *
     * @return array
     */
    public function getSiteMapItems(): array
    {
        $items = $this->repository->getAllItems();

        $resource = app()->make('InetStudio\Battles\Contracts\Transformers\Front\BattlesSiteMapTransformerContract')
            ->transformCollection($items);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();

        return $transformation['data'];
    }
}
