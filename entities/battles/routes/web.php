<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\BattlesPackage\Battles\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back',
    ],
    function () {
        Route::any('battles/data', 'DataControllerContract@getIndexData')
            ->name('back.battles.data.index');

        Route::post('battles/slug', 'UtilityControllerContract@getSlug')
            ->name('back.battles.getSlug');

        Route::post('battles/suggestions','UtilityControllerContract@getSuggestions')
            ->name('back.battles.getSuggestions');

        Route::resource(
            'battles',
            'ResourceControllerContract',
            [
                'as' => 'back'
            ]
        )->parameters(
            [
                'battles' => 'id'
            ]
        );
    }
);
