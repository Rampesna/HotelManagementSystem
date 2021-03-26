<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers\\Ajax')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::get('getCustomersByKeyword', 'CustomersController@getCustomersByKeyword')->name('ajax.customers.getCustomersByKeyword');

    });

    Route::prefix('room-types')->group(function () {
        Route::get('getRoomTypesByKeyword', 'RoomTypesController@getRoomTypesByKeyword')->name('ajax.room-types.getRoomTypesByKeyword');
    });

    Route::prefix('pan-types')->group(function () {
        Route::get('getPanTypesByKeyword', 'PanTypesController@getPanTypesByKeyword')->name('ajax.pan-types.getPanTypesByKeyword');
    });

    Route::prefix('rooms')->group(function () {
        Route::get('getRoomsByPanTypeAndRoomType', 'RoomsController@getRoomsByPanTypeAndRoomType')->name('ajax.rooms.getRoomsByPanTypeAndRoomType');
    });

    Route::prefix('reservations')->group(function () {
        Route::any('index','ReservationsController@index')->name('ajax.reservations.index');
        Route::any('create', 'ReservationsController@create')->name('ajax.reservations.create');
        Route::any('setStatus', 'ReservationsController@setStatus')->name('ajax.reservations.setStatus');
    });
});
