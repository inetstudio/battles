<?php

namespace InetStudio\BattlesPackage\Battles\Events\Front;

use Illuminate\Queue\SerializesModels;
use InetStudio\BattlesPackage\Battles\Contracts\Events\Front\ItemVoteResultChangedContract;

/**
 * Class ItemVoteResultChanged.
 */
class ItemVoteResultChanged implements ItemVoteResultChangedContract
{
    use SerializesModels;

    /**
     * @var
     */
    public $item;

    /**
     * ItemRateChanged constructor.
     *
     * @param   $item
     */
    public function __construct($item)
    {
        $this->item = $item;
    }
}
