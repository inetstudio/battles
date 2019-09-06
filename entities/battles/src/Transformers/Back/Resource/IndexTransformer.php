<?php

namespace InetStudio\BattlesPackage\Battles\Transformers\Back\Resource;

use Throwable;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends BaseTransformer implements IndexTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param BattleModelContract $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(BattleModelContract $item): array
    {
        return [
            'id' => (int) $item['id'],
            'title' => $item['title'],
            'status' => view(
                'admin.module.battles::back.partials.datatables.status',
                [
                    'status' => $item['status'],
                ]
            )->render(),
            'created_at' => (string) $item['created_at'],
            'updated_at' => (string) $item['updated_at'],
            'publish_date' => (string) $item['publish_date'],
            'actions' => view(
                'admin.module.battles::back.partials.datatables.actions',
                [
                    'id' => $item['id'],
                    'href' => $item['href'],
                ]
            )->render(),
        ];
    }
}
