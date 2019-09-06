<?php

namespace InetStudio\BattlesPackage\Battles\Services\Front;

use League\Fractal\Manager;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Front\SitemapServiceContract;

/**
 * Class SitemapService.
 */
class SitemapService extends BaseService implements SitemapServiceContract
{
    /**
     * SitemapService constructor.
     *
     * @param  BattleModelContract  $model
     */
    public function __construct(BattleModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем информацию по объектам для карты сайта.
     *
     * @param  array $params
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getItems(array $params = []): array
    {
        $items = $this->model->buildQuery($params)->get();

        $transformer = app()->make(
            'InetStudio\BattlesPackage\Battles\Contracts\Transformers\Front\Sitemap\ItemTransformerContract'
        );

        $resource = $transformer->transformCollection($items);

        $manager = new Manager();
        $serializer = app()->make(
            'InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract'
        );
        $manager->setSerializer($serializer);

        $data = $manager->createData($resource)->toArray();

        return $data;
    }
}
