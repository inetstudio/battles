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
     * Получаем объекты по списку id.
     *
     * @param array|int $ids
     * @param array $params
     *
     * @return mixed
     */
    public function getBattlesByIDs($ids, array $params = [])
    {
        return $this->repository->getItemsByIDs($ids, $params);
    }

    /**
     * Получаем объект по slug.
     *
     * @param string $slug
     * @param array $params
     *
     * @return mixed
     */
    public function getBattleBySlug(string $slug, array $params = [])
    {
        return $this->repository->getItemBySlug($slug, $params);
    }

    /**
     * Получаем объекты по тегу.
     *
     * @param string $tagSlug
     * @param array $params
     *
     * @return mixed
     */
    public function getBattlesByTag(string $tagSlug, array $params = [])
    {
        return $this->repository->getItemsByTag($tagSlug, $params);
    }

    /**
     * Получаем объекты по категории.
     *
     * @param string $categorySlug
     * @param array $params
     *
     * @return mixed
     */
    public function getBattlesByCategory(string $categorySlug, array $params = [])
    {
        return $this->repository->getItemsByCategory($categorySlug, $params);
    }

    /**
     * Получаем объекты из категорий.
     *
     * @param $categories
     * @param array $params
     *
     * @return mixed
     */
    public function getBattlesFromCategories($categories, array $params = [])
    {
        return $this->repository->getItemsFromCategories($categories, $params);
    }

    /**
     * Получаем объекты из любых категорий.
     *
     * @param $categories
     * @param array $params
     *
     * @return mixed
     */
    public function getBattlesByAnyCategory($categories, array $params = [])
    {
        return $this->repository->getItemsByAnyCategory($categories, $params);
    }

    /**
     * Получаем сохраненные объекты пользователя.
     *
     * @param int $userID
     * @param array $params
     *
     * @return mixed
     */
    public function getBattlesFavoritedByUser(int $userID, array $params = [])
    {
        return $this->repository->getItemsFavoritedByUser($userID, $params);
    }

    /**
     * Получаем все объекты.
     *
     * @param array $params
     *
     * @return mixed
     */
    public function getAllBattles(array $params = [])
    {
        return $this->repository->getAllItems($params);
    }

    /**
     * Получаем информацию по ингредиентам для фида.
     *
     * @return array
     */
    public function getFeedItems(): array
    {
        $items = $this->repository->getItemsQuery([
                'columns' => ['title', 'description', 'content', 'publish_date'],
                'relations' => ['categories'],
                'order' => ['publish_date' => 'desc'],
                'paging' => [
                    'page' => 0,
                    'limit' => 500,
                ],
            ])
            ->whereNotNull('publish_date')
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
