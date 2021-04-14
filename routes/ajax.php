<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers\\Ajax')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::any('index', 'CustomersController@index')->name('ajax.customers.index');
        Route::post('create', 'CustomersController@create')->name('ajax.customers.create');
        Route::get('edit', 'CustomersController@edit')->name('ajax.customers.edit');
        Route::get('getCustomersByKeyword', 'CustomersController@getCustomersByKeyword')->name('ajax.customers.getCustomersByKeyword');
    });

    Route::prefix('room-types')->group(function () {
        Route::get('getRoomTypesByKeyword', 'RoomTypesController@getRoomTypesByKeyword')->name('ajax.room-types.getRoomTypesByKeyword');
    });

    Route::prefix('pan-types')->group(function () {
        Route::get('getPanTypesByKeyword', 'PanTypesController@getPanTypesByKeyword')->name('ajax.pan-types.getPanTypesByKeyword');
    });

    Route::prefix('rooms')->group(function () {
        Route::get('show', 'RoomsController@show')->name('ajax.rooms.show');
        Route::get('getRoomsByPanTypeAndRoomType', 'RoomsController@getRoomsByPanTypeAndRoomType')->name('ajax.rooms.getRoomsByPanTypeAndRoomType');
        Route::get('getRoomsByParameters', 'RoomsController@getRoomsByParameters')->name('ajax.rooms.getRoomsByParameters');
        Route::post('setRoomStatus', 'RoomsController@setRoomStatus')->name('ajax.rooms.setRoomStatus');
    });

    Route::prefix('reservations')->group(function () {
        Route::any('index', 'ReservationsController@index')->name('ajax.reservations.index');
        Route::any('edit', 'ReservationsController@edit')->name('ajax.reservations.edit');
        Route::any('save', 'ReservationsController@save')->name('ajax.reservations.save');
        Route::any('setStatus', 'ReservationsController@setStatus')->name('ajax.reservations.setStatus');
        Route::any('debtControl', 'ReservationsController@debtControl')->name('ajax.reservations.debtControl');
        Route::any('safeActivities', 'ReservationsController@safeActivities')->name('ajax.reservations.safeActivities');
    });

    Route::prefix('safes')->group(function () {
        Route::any('index', 'SafesController@reservations')->name('ajax.safes.reservations');
        Route::any('getPayment', 'SafesController@getPayment')->name('ajax.safes.getPayment');
    });

    Route::prefix('stayers')->group(function () {
        Route::any('index', 'StayersController@reservations')->name('ajax.stayers.reservations');
    });

    Route::prefix('extras')->group(function () {
        Route::get('getByReservationId', 'ExtrasController@getByReservationId')->name('ajax.extras.getByReservationId');
        Route::post('create', 'ExtrasController@create')->name('ajax.extras.create');
    });
});
