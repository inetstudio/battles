<?php

namespace InetStudio\BattlesPackage\Battles\Transformers\Front\Sitemap;

use Carbon\Carbon;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Transformers\Front\Sitemap\ItemTransformerContract;

/**
 * Class ItemTransformer.
 */
class ItemTransformer extends BaseTransformer implements ItemTransformerContract
{
    /**
     * Подготовка данных для отображения в карте сайта.
     *
     * @param BattleModelContract $item
     *
     * @return array
     */
    public function transform(BattleModelContract $item): array
    {
        /** @var Carbon $updatedAt */
        $updatedAt = $item['updated_at'];

        return [
            'loc' => $item['href'],
            'lastmod' => $updatedAt->toW3cString(),
            'priority' => '1.0',
            'freq' => 'daily',
        ];
    }
}
