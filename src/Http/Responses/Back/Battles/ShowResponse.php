<?php

namespace InetStudio\Battles\Http\Responses\Back\Battles;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Battles\Contracts\Models\BattleModelContract;
use InetStudio\Battles\Contracts\Http\Responses\Back\Battles\ShowResponseContract;

/**
 * Class ShowResponse.
 */
class ShowResponse implements ShowResponseContract, Responsable
{
    /**
     * @var BattleModelContract
     */
    private $item;

    /**
     * ShowResponse constructor.
     *
     * @param BattleModelContract $item
     */
    public function __construct(BattleModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при получении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json($this->item);
    }
}
