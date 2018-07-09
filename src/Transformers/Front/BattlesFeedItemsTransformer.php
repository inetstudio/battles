<?php

namespace InetStudio\Battles\Transformers\Front;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Transformers\Front\BattlesFeedItemsTransformerContract;

/**
 * Class BattlesFeedItemsTransformer.
 */
class BattlesFeedItemsTransformer extends TransformerAbstract implements BattlesFeedItemsTransformerContract
{
    /**
     * Подготовка данных для отображения в фиде.
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
            'title' => $item->title,
            'author' => $this->getAuthor($item),
            'link' => $item->href,
            'pubdate' => $item->publish_date,
            'description' => $item->description,
            'content' => $item->content,
            'enclosure' => [],
            'category' => ($item->categories->count() > 0) ? $item->categories->first()->title : '',
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

    /**
     * Получаем автора статьи.
     *
     * @param BattleModelContract $item
     *
     * @return string
     */
    private function getAuthor(BattleModelContract $item): string
    {
        foreach ($item->revisionHistory as $history) {
            if ($history->key == 'created_at' && ! $history->old_value) {
                $user = $history->userResponsible();

                return ($user) ? $user->name : '';
            }
        }

        return '';
    }
}
