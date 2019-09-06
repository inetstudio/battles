<?php

namespace InetStudio\BattlesPackage\Battles\Http\Responses\Back\Resource;

use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\DataTables\IndexServiceContract as DataTableServiceContract;

/**
 * Class IndexResponse.
 */
class IndexResponse extends BaseResponse implements IndexResponseContract
{
    /**
     * @var array
     */
    protected $datatableService;

    /**
     * IndexResponse constructor.
     *
     * @param  DataTableServiceContract  $datatableService
     */
    public function __construct(DataTableServiceContract $datatableService)
    {
        $this->datatableService = $datatableService;
        $this->view = 'admin.module.battles::back.pages.index';
    }

    /**
     * Prepare response data.
     *
     * @param $request
     *
     * @return array
     */
    protected function prepare($request): array
    {
        $table = $this->datatableService->html();

        return compact('table');
    }
}
