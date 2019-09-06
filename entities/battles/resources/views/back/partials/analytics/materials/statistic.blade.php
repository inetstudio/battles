@inject('battlesService', 'InetStudio\BattlesPackage\Battles\Contracts\Services\Back\ItemsServiceContract')

@php
    $battles = $battlesService->getItemsStatisticByStatus();
@endphp

<li>
    <small class="label label-default">{{ $battles->sum('total') }}</small>
    <span class="m-l-xs">Битвы</span>
    <ul class="todo-list m-t">
        @foreach ($battles as $battle)
            <li>
                <small class="label label-{{ $battle->status->color_class }}">{{ $battle->total }}</small>
                <span class="m-l-xs">{{ $battle->status->name }}</span>
            </li>
        @endforeach
    </ul>
</li>
