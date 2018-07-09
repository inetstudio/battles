<?php

namespace InetStudio\Battles\Observers;

use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Observers\BattleObserverContract;

/**
 * Class BattleObserver.
 */
class BattleObserver implements BattleObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    public $services;

    /**
     * BattleObserver constructor.
     */
    public function __construct()
    {
        $this->services['battlesObserver'] = app()->make('InetStudio\Battles\Contracts\Services\Back\BattlesObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param BattleModelContract $item
     */
    public function creating(BattleModelContract $item): void
    {
        $this->services['battlesObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param BattleModelContract $item
     */
    public function created(BattleModelContract $item): void
    {
        $this->services['battlesObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param BattleModelContract $item
     */
    public function updating(BattleModelContract $item): void
    {
        $this->services['battlesObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param BattleModelContract $item
     */
    public function updated(BattleModelContract $item): void
    {
        $this->services['battlesObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param BattleModelContract $item
     */
    public function deleting(BattleModelContract $item): void
    {
        $this->services['battlesObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param BattleModelContract $item
     */
    public function deleted(BattleModelContract $item): void
    {
        $this->services['battlesObserver']->deleted($item);
    }
}
