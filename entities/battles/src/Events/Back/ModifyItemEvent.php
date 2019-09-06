<?php

namespace InetStudio\BattlesPackage\Battles\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var BattleModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  BattleModelContract  $item
     */
    public function __construct(BattleModelContract $item)
    {
        $this->item = $item;
    }
}
