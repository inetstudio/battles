<?php

namespace InetStudio\BattlesPackage\Battles\Transformers\Back\Utility;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Transformers\Back\Utility\SuggestionTransformerContract;

/**
 * Class SuggestionTransformer.
 */
class SuggestionTransformer extends BaseTransformer implements SuggestionTransformerContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * SuggestionTransformer constructor.
     *
     * @param  string  $type
     */
    public function __construct(string $type = '')
    {
        $this->type = $type;
    }

    /**
     * Трансформация данных.
     *
     * @param  BattleModelContract  $item
     *
     * @return array
     */
    public function transform(BattleModelContract $item): array
    {
        return ($this->type == 'autocomplete')
            ? [
                'value' => $item['title'],
                'data' => [
                    'id' => $item['id'],
                    'type' => get_class($item),
                    'title' => $item['title'],
                    'path' => parse_url($item['href'], PHP_URL_PATH),
                    'href' => $item['href'],
                ],
            ]
            : [
                'id' => $item['id'],
                'name' => $item['title'],
            ];
    }
}
