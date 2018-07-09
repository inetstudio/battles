<?php

namespace InetStudio\Battles\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Battles\Contracts\Events\Back\ModifyBattleEventContract;

/**
 * Class ModifyBattleEvent.
 */
class ModifyBattleEvent implements ModifyBattleEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyBattleEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
