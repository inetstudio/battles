<?php

namespace InetStudio\Battles\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Transformers\Back\BattleTransformerContract;

/**
 * Class BattleTransformer.
 */
class BattleTransformer extends TransformerAbstract implements BattleTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
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
            'id' => (int) $item->id,
            'title' => $item->title,
            'status' => view('admin.module.battles::back.partials.datatables.status', [
                'status' => $item->status,
            ])->render(),
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
            'publish_date' => (string) $item->publish_date,
            'actions' => view('admin.module.battles::back.partials.datatables.actions', [
                'id' => $item->id,
                'href' => $item->href,
            ])->render(),
        ];
    }
}
