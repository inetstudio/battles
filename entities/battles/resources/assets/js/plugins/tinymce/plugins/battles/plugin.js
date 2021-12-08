import Swal from 'sweetalert2';

window.tinymce.PluginManager.add('battles', function (editor) {
    editor.addButton('add_battle_widget', {
        title: 'Битвы',
        icon: 'a11y',
        onclick: function () {
            editor.focus();

            let content = editor.selection.getContent();
            let battleWidgetID = '';

            if (content !== '' && ! /<img class="content-widget".+data-type="battle".+\/>/g.test(content)) {
                Swal.fire({
                    title: "Ошибка",
                    text: "Необходимо выбрать виджет-битву",
                    icon: "error"
                });

                return false;
            } else if (content !== '') {
                battleWidgetID = $(content).attr('data-id');

                window.Admin.modules.widgets.getWidget(battleWidgetID, function (widget) {
                    $('#choose_battle_modal .choose-data').val(JSON.stringify(widget.additional_info));
                    $('#choose_battle_modal input[name=battle]').val(widget.additional_info.title);
                });
            }

            $('#choose_battle_modal .save').off('click');
            $('#choose_battle_modal .save').on('click', function (event) {
                event.preventDefault();

                let data = JSON.parse($('#choose_battle_modal .choose-data').val());

                window.Admin.modules.widgets.saveWidget(battleWidgetID, {
                    view: 'admin.module.battles::front.partials.content.battle_widget',
                    params: {
                        id: data.id
                    },
                    additional_info: data
                }, {
                    editor: editor,
                    type: 'battle',
                    alt: 'Виджет-битва: '+data.title
                }, function (widget) {
                    $('#choose_battle_modal').modal('hide');
                });
            });

            $('#choose_battle_modal').modal();
        }
    })
});
