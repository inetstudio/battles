<?php

namespace InetStudio\Battles\Http\Responses\Back\Battles;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Battles\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var BattleModelContract
     */
    private $item;

    /**
     * SaveResponse constructor.
     *
     * @param BattleModelContract $item
     */
    public function __construct(BattleModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        return response()->redirectToRoute('back.battles.edit', [
            $this->item->fresh()->id,
        ]);
    }
}
