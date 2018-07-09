<?php

namespace InetStudio\Battles\Transformers\Front;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Transformers\Front\BattlesSiteMapTransformerContract;

/**
 * Class BattlesSiteMapTransformer.
 */
class BattlesSiteMapTransformer extends TransformerAbstract implements BattlesSiteMapTransformerContract
{
    /**
     * Подготовка данных для отображения в карте сайта.
     *
     * @param BattleModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(BattleModelContract $item): array
    {
        return [
            'loc' => $item->href,
            'lastmod' => $item->updated_at->toW3cString(),
            'priority' => '1.0',
            'freq' => 'daily',
        ];
    }

    /**
     * Обработка коллекции статей.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
