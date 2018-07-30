<?php

Route::group([
    'namespace' => 'InetStudio\Battles\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('battles/data', 'BattlesDataControllerContract@data')->name('back.battles.data.index');
    Route::post('battles/slug', 'BattlesUtilityControllerContract@getSlug')->name('back.battles.getSlug');
    Route::post('battles/suggestions', 'BattlesUtilityControllerContract@getSuggestions')->name('back.battles.getSuggestions');

    Route::resource('battles', 'BattlesControllerContract', ['as' => 'back']);
});

Route::group([
    'namespace' => 'InetStudio\Battles\Contracts\Http\Controllers\Front',
    'middleware' => ['web'],
], function () {
    Route::post('battles/vote/{battleID}/{optionID}', 'BattlesVotesControllerContract@vote')->name('front.battles.vote');
});
