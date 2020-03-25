<?php

namespace InetStudio\BattlesPackage\Battles\Models;

use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use InetStudio\Widgets\Models\Traits\HasWidgets;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use InetStudio\MetaPackage\Meta\Models\Traits\HasMeta;
use InetStudio\TagsPackage\Tags\Models\Traits\HasTags;
use InetStudio\Classifiers\Models\Traits\HasClassifiers;
use InetStudio\StatusesPackage\Statuses\Models\Traits\Status;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AccessPackage\Fields\Models\Traits\HasFieldsAccess;
use InetStudio\CommentsPackage\Comments\Models\Traits\HasComments;
use InetStudio\CategoriesPackage\Categories\Models\Traits\HasCategories;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\SimpleCounters\Counters\Models\Traits\HasSimpleCountersTrait;

/**
 * Class BattleModel.
 */
class BattleModel extends Model implements BattleModelContract
{
    use HasMeta;
    use HasTags;
    use Auditable;
    use HasImages;
    use Sluggable;
    use HasWidgets;
    use Searchable;
    use HasComments;
    use SoftDeletes;
    use HasCategories;
    use HasClassifiers;
    use HasFieldsAccess;
    use BuildQueryScopeTrait;
    use SluggableScopeHelpers;
    use HasSimpleCountersTrait;

    /**
     * Тип сущности.
     */
    const ENTITY_TYPE = 'battle';

    /**
     * Тип материала.
     */
    const BASE_MATERIAL_TYPE = 'battle';

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

    /**
     * Настройки для генерации изображений.
     *
     * @var array
     */
    protected $images = [
        'config' => 'battles',
        'model' => '',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'battles';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'publish_date',
        'webmaster_id',
        'status_id',
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
        'publish_date',
    ];

    /**
     * Настройка полей для поиска.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $arr = Arr::only($this->toArray(), ['id', 'title', 'description', 'content']);

        $arr['tags'] = $this->tags->map(function ($item) {
            return Arr::only($item->toSearchableArray(), ['id', 'name']);
        })->toArray();

        return $arr;
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableIndex()
    {
        return trim(config('scout.elasticsearch.index', '').'_battles', '_');
    }

    /**
     * Get the _type name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return '_doc';
    }

    /**
     * Возвращаем конфиг для генерации slug модели.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true,
            ],
        ];
    }

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'slug',
            'title',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'fields_access' => function ($query) {
                $query->select(['model_id', 'model_type', 'field', 'access']);
            },

            'meta' => function ($query) {
                $query->select(['metable_id', 'metable_type', 'key', 'value']);
            },

            'media' => function ($query) {
                $query->select([
                    'id',
                    'model_id',
                    'model_type',
                    'collection_name',
                    'file_name',
                    'disk',
                    'conversions_disk',
                    'uuid',
                    'mime_type',
                    'custom_properties',
                    'responsive_images',
                ]);
            },

            'tags' => function ($query) {
                $query->select(['id', 'name', 'slug']);
            },

            'categories' => function ($query) {
                $query->select(['id', 'parent_id', 'name', 'slug', 'title', 'description'])->whereNotNull('parent_id');
            },

            'counters' => function ($query) {
                $query->select(['countable_id', 'countable_type', 'type', 'counter']);
            },

            'status' => function ($query) {
                $query->select(['id', 'name', 'alias', 'color_class']);
            },
        ];
    }

    /**
     * Сеттер атрибута title.
     *
     * @param $value
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = strip_tags($value);
    }

    /**
     * Сеттер атрибута slug.
     *
     * @param $value
     */
    public function setSlugAttribute($value): void
    {
        $this->attributes['slug'] = strip_tags($value);
    }

    /**
     * Сеттер атрибута description.
     *
     * @param $value
     */
    public function setDescriptionAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['description'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Сеттер атрибута content.
     *
     * @param $value
     */
    public function setContentAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['content'] = trim(str_replace('&nbsp;', ' ', $value));
    }

    /**
     * Сеттер атрибута publish_date.
     *
     * @param $value
     */
    public function setPublishDateAttribute($value)
    {
        $this->attributes['publish_date'] = ($value) ? Carbon::createFromFormat('d.m.Y H:i', $value) : null;
    }

    /**
     * Сеттер атрибута webmaster_id.
     *
     * @param $value
     */
    public function setWebmasterIdAttribute($value)
    {
        $this->attributes['webmaster_id'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута status_id.
     *
     * @param $value
     */
    public function setStatusIdAttribute($value)
    {
        $this->attributes['status_id'] = (! $value) ? 1 : (int) $value;
    }

    /**
     * Сеттер атрибута material_type.
     *
     * @param $value
     */
    public function setMaterialTypeAttribute($value): void
    {
        $this->attributes['material_type'] = ($value) ? $value : self::BASE_MATERIAL_TYPE;

        $this->images['model'] = $this->attributes['material_type'];
    }

    /**
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * Геттер атрибута href.
     *
     * @return string
     */
    public function getHrefAttribute()
    {
        return url($this['material_type'].'/'.(! empty($this['slug']) ? $this['slug'] : $this['id']));
    }

    /**
     * Геттер атрибута material_type.
     *
     * @return string
     */
    public function getMaterialTypeAttribute()
    {
        return self::BASE_MATERIAL_TYPE;
    }

    use Status;

    /**
     * Отношение "один ко многим" с моделью голосов.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function votes()
    {
        $voteModel = app()->make('InetStudio\BattlesPackage\Votes\Contracts\Models\VoteModelContract');

        return $this->hasMany(
            get_class($voteModel),
            'battle_id',
            'id'
        );
    }
}
