<?php

namespace InetStudio\Battles\Http\Responses\Front\BattlesVotes;

use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Battles\Contracts\Http\Responses\Front\BattlesVotes\VoteResponseContract;

/**
 * Class VoteResponse.
 */
class VoteResponse implements VoteResponseContract, Responsable
{
    /**
     * @var array
     */
    private $ratio;

    /**
     * VoteResponse constructor.
     *
     * @param array $ratio
     */
    public function __construct(array $ratio)
    {
        $this->ratio = $ratio;
    }

    /**
     * Возвращаем slug по заголовку объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return JsonResponse
     */
    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'ratio' => $this->ratio,
        ]);
    }
}
