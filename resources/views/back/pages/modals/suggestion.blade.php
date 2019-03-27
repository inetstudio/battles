@pushonce('modals:choose_battle')
    <div id="choose_battle_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Выберите битву</h1>
                </div>

                <div class="modal-body">
                    <div class="ibox-content">

                            {!! Form::hidden('battle_data', '', [
                                'class' => 'choose-data',
                                'id' => 'battle_data',
                            ]) !!}

                            {!! Form::string('battle', '', [
                                'label' => [
                                    'title' => 'Битвы',
                                ],
                                'field' => [
                                    'class' => 'form-control autocomplete',
                                    'data-search' => route('back.battles.getSuggestions'),
                                    'data-target' => '#battle_data'
                                ],
                            ]) !!}

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary save">Сохранить</a>
                </div>

            </div>
        </div>
    </div>
@endpushonce
