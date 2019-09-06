<?php

namespace InetStudio\BattlesPackage\Battles\Http\Responses\Back\Utility;

use League\Fractal\Manager;
use InetStudio\AdminPanel\Base\Http\Responses\BaseResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\BattlesPackage\Battles\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class SuggestionsResponse.
 */
class SuggestionsResponse extends BaseResponse implements SuggestionsResponseContract
{
    /**
     * @var UtilityServiceContract
     */
    protected $utilityService;

    /**
     * SuggestionsResponse constructor.
     *
     * @param  UtilityServiceContract  $utilityService
     */
    public function __construct(UtilityServiceContract $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    /**
     * Prepare response data.
     *
     * @param $request
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    protected function prepare($request): array
    {
        $search = $request->get('q');
        $type = $request->get('type');

        $items = $this->utilityService->getSuggestions($search);

        $transformer = app()->make(
            'InetStudio\BattlesPackage\Battles\Contracts\Transformers\Back\Utility\SuggestionTransformerContract',
            [
                'type' => $this->type,
            ]
        );

        $resource = $transformer->transformCollection($items);

        $serializer = app()->make('InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract');

        $manager = new Manager();
        $manager->setSerializer($serializer);

        $transformation = $manager->createData($resource)->toArray();

        $data = [
            'suggestions' => [],
            'items' => [],
        ];

        if ($type == 'autocomplete') {
            $data['suggestions'] = $transformation;
        } else {
            $data['items'] = $transformation;
        }

        return [
            $data,
        ];
    }
}
