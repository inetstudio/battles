<?php

namespace InetStudio\BattlesPackage\Battles\Services\Back\DataTables;

use Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\BattlesPackage\Battles\Contracts\Models\BattleModelContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\DataTables\IndexServiceContract;

/**
 * Class IndexService.
 */
class IndexService extends DataTable implements IndexServiceContract
{
    /**
     * @var
     */
    protected $model;

    /**
     * DataTableService constructor.
     *
     * @param  BattleModelContract  $model
     */
    public function __construct(BattleModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Запрос на получение данных таблицы.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(): JsonResponse
    {
        $transformer = app()->make('InetStudio\BattlesPackage\Battles\Contracts\Transformers\Back\Resource\IndexTransformerContract');

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['status', 'actions'])
            ->make();
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->model->buildQuery(
            [
                'columns' => ['status_id', 'created_at', 'updated_at', 'publish_date'],
                'relations' => ['status'],
            ]
        );

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return Builder
     */
    public function html(): Builder
    {
        /** @var Builder $table */
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'title', 'name' => 'title', 'title' => 'Заголовок'],
            ['data' => 'status', 'name' => 'status.name', 'title' => 'Статус', 'orderable' => false],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления'],
            ['data' => 'publish_date', 'name' => 'publish_date', 'title' => 'Дата публикации'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Действия', 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.battles.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'order' => [
                2,
                'desc',
            ],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
