<?php

namespace InetStudio\BattlesPackage\Votes\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\BattlesPackage\Votes\Contracts\Models\VoteModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class VoteModel.
 */
class VoteModel extends Model implements VoteModelContract
{
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Тип сущности.
     */
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
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'battle_id',
            'option_id',
            'user_id',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'battle' => function ($query) {
                $query->select(['id', 'title', 'slug']);
            },
        ];
    }

    /**
     * Сеттер атрибута battle_id.
     *
     * @param $value
     */
    public function setBattleIdAttribute($value): void
    {
        $this->attributes['battle_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута option_id.
     *
     * @param $value
     */
    public function setOptionIdAttribute($value): void
    {
        $this->attributes['option_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута user_id.
     *
     * @param $value
     */
    public function setUserIdAttribute($value): void
    {
        $this->attributes['user_id'] = trim(strip_tags($value));
    }

    /**
     * Обратное отношение "один ко многим" с моделью битвы.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function battle()
    {
        $battleModel = app()->make('InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract');

        return $this->belongsTo(
            get_class($battleModel),
            'battle_id'
        );
    }
}
