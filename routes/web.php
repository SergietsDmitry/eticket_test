<?php

Route::group(['middleware' => 'web'], function () {
    
    Route::group(['middleware' => 'PingEtmApi'], function () {
        Route::get('/', 'MainController@index')->name('index');
    });
    
    Route::post('/doAirFareRequest', 'MainController@doAirFareRequest')->name('get.search.id');
    Route::get('/result/{request_id}', 'MainController@searching')->name('search.flight');
    Route::post('/getAirFareResult/{request_id}', 'MainController@getAirFareResult')->name('get.search.result');
});