<?php

namespace InetStudio\BattlesPackage\Battles\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\UploadsPackage\Uploads\Validation\Rules\CropSize;
use InetStudio\BattlesPackage\Battles\Contracts\Http\Requests\Back\SaveItemRequestContract;

/**
 * Class SaveItemRequest.
 */
class SaveItemRequest extends FormRequest implements SaveItemRequestContract
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        $cropMessages = [];

        foreach (['first_option', 'second_option'] as $option) {
            $crops = config('battles.images.crops.battle.'.$option) ?? [];

            foreach ($crops as $crop) {
                $cropMessages[$option.'.crop.'.$crop['name'].'.required'] = 'Необходимо выбрать область отображения '.$crop['ratio'];
                $cropMessages[$option.'.crop.'.$crop['name'].'.json'] = 'Область отображения '.$crop['ratio'].' должна быть представлена в виде JSON';
            }
        }

        return array_merge(
            [
                'meta.title.max' => 'Поле «Title» не должно превышать 255 символов',
                'meta.description.max' => 'Поле «Description» не должно превышать 255 символов',
                'meta.keywords.max' => 'Поле «Keywords» не должно превышать 255 символов',

                'meta.og:title.max' => 'Поле «og:title» не должно превышать 255 символов',
                'meta.og:description.max' => 'Поле «og:description» не должно превышать 255 символов',

                'og_image.crop.default.json' => 'Область отображения должна быть представлена в виде JSON',

                'title.required' => 'Поле «Заголовок» обязательно для заполнения',
                'title.max' => 'Поле «Заголовок» не должно превышать 255 символов',

                'slug.required' => 'Поле «URL» обязательно для заполнения',
                'slug.alpha_dash' => 'Поле «URL» может содержать только латинские символы, цифры, дефисы и подчеркивания',
                'slug.max' => 'Поле «URL» не должно превышать 255 символов',
                'slug.unique' => 'Такое значение поля «URL» уже существует',

                'first_option.file.required' => 'Поле «Вариант 1» обязательно для заполнения',
                'first_option.description.max' => 'Поле «Описание» не должно превышать 255 символов',
                'first_option.copyright.max' => 'Поле «Copyright» не должно превышать 255 символов',
                'first_option.alt.required' => 'Поле «Alt» обязательно для заполнения',
                'first_option.alt.max' => 'Поле «Alt» не должно превышать 255 символов',

                'second_option.file.required' => 'Поле «Вариант 2» обязательно для заполнения',
                'second_option.description.max' => 'Поле «Описание» не должно превышать 255 символов',
                'second_option.copyright.max' => 'Поле «Copyright» не должно превышать 255 символов',
                'second_option.alt.required' => 'Поле «Alt» обязательно для заполнения',
                'second_option.alt.max' => 'Поле «Alt» не должно превышать 255 символов',

                'tags.array' => 'Поле «Теги» должно содержать значение в виде массива',

                'publish_date.date_format' => 'Поле «Время публикации» должно быть в формате дд.мм.гггг чч:мм',
            ],
            $cropMessages
        );
    }

    /**
     * Правила проверки запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        $cropRules = [];

        foreach (['first_option', 'second_option'] as $option) {
            $crops = config('battles.images.crops.battle.'.$option) ?? [];

            foreach ($crops as $crop) {
                $cropRules[$option.'.crop.'.$crop['name']] = [
                    'nullable', 'json',
                    new CropSize($crop['size']['width'], $crop['size']['height'], $crop['size']['type'], $crop['ratio']),
                ];
            }
        }

        return array_merge(
            [
                'meta.title' => 'max:255',
                'meta.description' => 'max:255',
                'meta.keywords' => 'max:255',
                'meta.og:title' => 'max:255',
                'meta.og:description' => 'max:255',

                'og_image.crop.default' => [
                    'nullable', 'json',
                    new CropSize(968, 475, 'min', ''),
                ],

                'title' => 'required|max:255',
                'slug' => 'required|alpha_dash|max:255|unique:battles,slug,'.$this->get('battle_id'),

                'first_option.description' => 'max:255',
                'first_option.copyright' => 'max:255',
                'first_option.alt' => 'required|max:255',

                'second_option.description' => 'max:255',
                'second_option.copyright' => 'max:255',
                'second_option.alt' => 'required|max:255',

                'tags' => 'array',
                'publish_date' => 'nullable|date_format:d.m.Y H:i',
            ],
            $cropRules
        );
    }
}
