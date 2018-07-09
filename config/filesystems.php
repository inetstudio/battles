<?php

return [

    /*
     * Расширение файла конфигурации app/config/filesystems.php
     * добавляет локальные диски для хранения изображений постов и пользователей
     */

    'battles' => [
        'driver' => 'local',
        'root' => storage_path('app/public/battles/'),
        'url' => env('APP_URL').'/storage/battles/',
        'visibility' => 'public',
    ],

];
