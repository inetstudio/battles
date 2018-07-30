<?php

namespace InetStudio\Battles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Battles\Contracts\Models\BattleVoteModelContract;

/**
 * Class BattleVoteModel.
 */
class BattleVoteModel extends Model implements BattleVoteModelContract
{
    use SoftDeletes;

    const ENTITY_TYPE = 'battle_vote';

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'battles_votes';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'battle_id', 'option_id', 'user_id',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Обратное отношение "один ко многим" с моделью битвы.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function battle()
    {
        return $this->belongsTo(
            app()->make('InetStudio\Battles\Contracts\Models\BattleModelContract'),
            'battle_id'
        );
    }
}
