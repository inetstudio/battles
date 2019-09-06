<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\BattlesPackage\Votes\Contracts\Http\Controllers\Front',
        'middleware' => ['web'],
    ],
    function () {
        Route::post('battles/vote/{battleId}/{optionId}','ItemsControllerContract@vote')
            ->name('front.battles.vote');
    }
);
