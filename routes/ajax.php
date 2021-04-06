<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers\\Ajax')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::post('create', 'CustomersController@create')->name('ajax.customers.create');
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
        Route::post('setRoomStatus', 'RoomsController@setRoomStatus')->name('ajax.rooms.setRoomStatus');
    });

    Route::prefix('reservations')->group(function () {
        Route::any('index', 'ReservationsController@index')->name('ajax.reservations.index');
        Route::any('edit', 'ReservationsController@edit')->name('ajax.reservations.edit');
        Route::any('save', 'ReservationsController@save')->name('ajax.reservations.save');
        Route::any('setStatus', 'ReservationsController@setStatus')->name('ajax.reservations.setStatus');
    });
});
