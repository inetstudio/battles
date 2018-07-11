<?php

return [

    /*
     * Настройки доступа
     */

    'access' => [
        'content' => 'Контент',
        'comments' => 'Комментарии',
    ],

    /*
     * Настройки изображений
     */

    'images' => [
        'quality' => 75,
        'conversions' => [
            'battle' => [
                'og_image' => [
                    'default' => [
                        [
                            'name' => 'og_image_default',
                            'size' => [
                                'width' => 968,
                                'height' => 475,
                            ],
                        ],
                    ],
                ],
                'first_option' => [
                    'vertical' => [
                        [
                            'name' => 'first_option_vertical',
                            'size' => [
                                'width' => 460,
                                'height' => 560,
                            ],
                        ],
                    ],
                ],
                'second_option' => [
                    'vertical' => [
                        [
                            'name' => 'second_option_vertical',
                            'size' => [
                                'width' => 460,
                                'height' => 560,
                            ],
                        ],
                    ],
                ],
                'content' => [
                    'default' => [
                        [
                            'name' => 'content_admin',
                            'size' => [
                                'width' => 140,
                            ],
                        ],
                        [
                            'name' => 'content_front',
                            'quality' => 70,
                            'fit' => [
                                'width' => 640,
                                'height' => 400,
                            ],
                        ],
                    ],
                ],
                'corrections' => [
                    'default' => [
                        [
                            'name' => 'corrections_admin',
                            'size' => [
                                'width' => 140,
                            ],
                        ],
                        [
                            'name' => 'corrections_front',
                            'quality' => 70,
                            'fit' => [
                                'width' => 640,
                                'height' => 400,
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'crops' => [
            'battle' => [
                'first_option' => [
                    [
                        'title' => 'Вертикальная ориентация',
                        'name' => 'vertical',
                        'ratio' => '460/560',
                        'size' => [
                            'width' => 460,
                            'height' => 560,
                            'type' => 'min',
                            'description' => 'Минимальный размер области — 460x560 пикселей'
                        ],
                    ],
                ],
                'second_option' => [
                    [
                        'title' => 'Вертикальная ориентация',
                        'name' => 'vertical',
                        'ratio' => '460/560',
                        'size' => [
                            'width' => 460,
                            'height' => 560,
                            'type' => 'min',
                            'description' => 'Минимальный размер области — 460x560 пикселей'
                        ],
                    ],
                ],
            ],
        ],
    ],
];
