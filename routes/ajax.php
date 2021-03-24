<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers\\Ajax')->group(function () {
    Route::get('getCustomersByKeyword', 'CustomersController@getCustomersByKeyword')->name('ajax.getCustomersByKeyword');

    Route::get('getRoomTypesByKeyword', 'RoomTypesController@getRoomTypesByKeyword')->name('ajax.getRoomTypesByKeyword');

    Route::get('getPanTypesByKeyword', 'PanTypesController@getPanTypesByKeyword')->name('ajax.getPanTypesByKeyword');

    Route::get('getRoomsByPanTypeAndRoomType', 'RoomsController@getRoomsByPanTypeAndRoomType')->name('ajax.getRoomsByPanTypeAndRoomType');
});
