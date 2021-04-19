<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\\Http\\Controllers\\Ajax')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::any('index', 'CustomersController@index')->name('ajax.customers.index');
        Route::post('create', 'CustomersController@save')->name('ajax.customers.save');
        Route::get('edit', 'CustomersController@edit')->name('ajax.customers.edit');
        Route::get('getCustomersByKeyword', 'CustomersController@getCustomersByKeyword')->name('ajax.customers.getCustomersByKeyword');
    });

    Route::prefix('companies')->group(function () {
        Route::get('index', 'CompaniesController@index')->name('ajax.companies.index');
        Route::post('save', 'CompaniesController@save')->name('ajax.companies.save');
        Route::get('show', 'CompaniesController@show')->name('ajax.companies.show');
        Route::post('delete', 'CompaniesController@delete')->name('ajax.companies.delete');
    });

    Route::prefix('room-types')->group(function () {
        Route::get('index', 'RoomTypesController@index')->name('ajax.room-types.index');
        Route::post('save', 'RoomTypesController@save')->name('ajax.room-types.save');
        Route::get('show', 'RoomTypesController@show')->name('ajax.room-types.show');
        Route::post('delete', 'RoomTypesController@delete')->name('ajax.room-types.delete');
        Route::get('getRoomTypesByKeyword', 'RoomTypesController@getRoomTypesByKeyword')->name('ajax.room-types.getRoomTypesByKeyword');
    });

    Route::prefix('pan-types')->group(function () {
        Route::get('index', 'PanTypesController@index')->name('ajax.pan-types.index');
        Route::post('save', 'PanTypesController@save')->name('ajax.pan-types.save');
        Route::get('show', 'PanTypesController@show')->name('ajax.pan-types.show');
        Route::post('delete', 'PanTypesController@delete')->name('ajax.pan-types.delete');
        Route::get('getPanTypesByKeyword', 'PanTypesController@getPanTypesByKeyword')->name('ajax.pan-types.getPanTypesByKeyword');
    });

    Route::prefix('extras')->group(function () {
        Route::get('index', 'ExtrasController@index')->name('ajax.extras.index');
        Route::post('save', 'ExtrasController@save')->name('ajax.extras.save');
        Route::get('show', 'ExtrasController@show')->name('ajax.extras.show');
        Route::post('delete', 'ExtrasController@delete')->name('ajax.extras.delete');
    });

    Route::prefix('room-use-types')->group(function () {
        Route::get('index', 'RoomUseTypesController@index')->name('ajax.room-use-types.index');
        Route::post('save', 'RoomUseTypesController@save')->name('ajax.room-use-types.save');
        Route::get('show', 'RoomUseTypesController@show')->name('ajax.room-use-types.show');
        Route::post('delete', 'RoomUseTypesController@delete')->name('ajax.room-use-types.delete');
    });

    Route::prefix('rooms')->group(function () {
        Route::get('index', 'RoomsController@index')->name('ajax.rooms.index');
        Route::post('save', 'RoomsController@save')->name('ajax.rooms.save');
        Route::get('show', 'RoomsController@show')->name('ajax.rooms.show');
        Route::post('delete', 'RoomsController@delete')->name('ajax.rooms.delete');
        Route::get('getRoomsByPanTypeAndRoomType', 'RoomsController@getRoomsByPanTypeAndRoomType')->name('ajax.rooms.getRoomsByPanTypeAndRoomType');
        Route::get('getRoomsByParameters', 'RoomsController@getRoomsByParameters')->name('ajax.rooms.getRoomsByParameters');
        Route::post('setRoomStatus', 'RoomsController@setRoomStatus')->name('ajax.rooms.setRoomStatus');
        Route::post('setRoomPriceCollective', 'RoomsController@setRoomPriceCollective')->name('ajax.rooms.setRoomPriceCollective');
        Route::post('setRoomStatusCollective', 'RoomsController@setRoomStatusCollective')->name('ajax.rooms.setRoomStatusCollective');
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

    Route::prefix('safe-activities')->group(function () {
        Route::post('create', 'SafeActivitiesController@create')->name('ajax.safe-activities.create');
        Route::get('getByReservationId', 'SafeActivitiesController@getByReservationId')->name('ajax.safe-activities.getByReservationId');
    });
});
