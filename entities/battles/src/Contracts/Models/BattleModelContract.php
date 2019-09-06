<?php

namespace InetStudio\BattlesPackage\Battles\Contracts\Models;

use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use InetStudio\Rating\Contracts\Models\Traits\RateableContract;
use InetStudio\AdminPanel\Base\Contracts\Models\BaseModelContract;
use InetStudio\Favorites\Contracts\Models\Traits\FavoritableContract;

/**
 * Interface BattleModelContract.
 */
interface BattleModelContract extends BaseModelContract, Auditable, FavoritableContract, HasMedia, RateableContract
{
}
