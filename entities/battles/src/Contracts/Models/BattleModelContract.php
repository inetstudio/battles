<?php

namespace InetStudio\BattlesPackage\Battles\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;

/**
 * Interface BattleModelContract.
 */
interface BattleModelContract extends BaseModelContract, Auditable, HasMedia
{
}
