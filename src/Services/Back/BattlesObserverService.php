<?php

namespace InetStudio\Battles\Services\Back;

use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Services\Back\BattlesObserverServiceContract;

/**
 * Class BattlesObserverService.
 */
class BattlesObserverService implements BattlesObserverServiceContract
{
    /**
     * @var
     */
    public $repository;

    /**
     * BattlesObserverService constructor.
     */
    public function __construct()
    {
        $this->repository = app()->make('InetStudio\Battles\Contracts\Repositories\BattlesRepositoryContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param BattleModelContract $item
     */
    public function creating(BattleModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param BattleModelContract $item
     */
    public function created(BattleModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param BattleModelContract $item
     */
    public function updating(BattleModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param BattleModelContract $item
     */
    public function updated(BattleModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param BattleModelContract $item
     */
    public function deleting(BattleModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param BattleModelContract $item
     */
    public function deleted(BattleModelContract $item): void
    {
    }
}
