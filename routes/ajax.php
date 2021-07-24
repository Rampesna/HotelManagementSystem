<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ajax\CustomersController;
use App\Http\Controllers\Ajax\CompaniesController;
use App\Http\Controllers\Ajax\RoomTypesController;
use App\Http\Controllers\Ajax\PanTypesController;
use App\Http\Controllers\Ajax\ExtrasController;
use App\Http\Controllers\Ajax\RoomUseTypesController;
use App\Http\Controllers\Ajax\RoomStatusesController;
use App\Http\Controllers\Ajax\RoomsController;
use App\Http\Controllers\Ajax\ReservationsController;
use App\Http\Controllers\Ajax\HandOversController;
use App\Http\Controllers\Ajax\DayEndsController;
use App\Http\Controllers\Ajax\ReceiptsController;
use App\Http\Controllers\Ajax\WaitingPaymentsController;
use App\Http\Controllers\Ajax\StayersController;
use App\Http\Controllers\Ajax\SafeActivitiesController;
use App\Http\Controllers\Ajax\SafesController;
use App\Http\Controllers\Ajax\RoleController;
use App\Http\Controllers\Ajax\UserController;
use App\Http\Controllers\Ajax\SettingsController;
use App\Http\Controllers\Ajax\ProfileController;

Route::namespace('App\\Http\\Controllers\\Ajax')->group(function () {
    Route::prefix('customers')->group(function () {
        Route::any('index', [CustomersController::class, 'index'])->name('ajax.customers.index');
        Route::post('create', [CustomersController::class, 'save'])->name('ajax.customers.save');
        Route::get('edit', [CustomersController::class, 'edit'])->name('ajax.customers.edit');
        Route::get('getCustomersByKeyword', [CustomersController::class, 'getCustomersByKeyword'])->name('ajax.customers.getCustomersByKeyword');
    });

    Route::prefix('companies')->group(function () {
        Route::get('index', [CompaniesController::class, 'index'])->name('ajax.companies.index');
        Route::post('save', [CompaniesController::class, 'save'])->name('ajax.companies.save');
        Route::get('show', [CompaniesController::class, 'show'])->name('ajax.companies.show');
        Route::post('delete', [CompaniesController::class, 'delete'])->name('ajax.companies.delete');
    });

    Route::prefix('room-types')->group(function () {
        Route::get('index', [RoomTypesController::class, 'index'])->name('ajax.room-types.index');
        Route::post('save', [RoomTypesController::class, 'save'])->name('ajax.room-types.save');
        Route::get('show', [RoomTypesController::class, 'show'])->name('ajax.room-types.show');
        Route::post('delete', [RoomTypesController::class, 'delete'])->name('ajax.room-types.delete');
        Route::get('getRoomTypesByKeyword', [RoomTypesController::class, 'getRoomTypesByKeyword'])->name('ajax.room-types.getRoomTypesByKeyword');
    });

    Route::prefix('pan-types')->group(function () {
        Route::get('index', [PanTypesController::class, 'index'])->name('ajax.pan-types.index');
        Route::post('save', [PanTypesController::class, 'save'])->name('ajax.pan-types.save');
        Route::get('show', [PanTypesController::class, 'show'])->name('ajax.pan-types.show');
        Route::post('delete', [PanTypesController::class, 'delete'])->name('ajax.pan-types.delete');
        Route::get('getPanTypesByKeyword', [PanTypesController::class, 'getPanTypesByKeyword'])->name('ajax.pan-types.getPanTypesByKeyword');
    });

    Route::prefix('extras')->group(function () {
        Route::get('index', [ExtrasController::class, 'index'])->name('ajax.extras.index');
        Route::post('save', [ExtrasController::class, 'save'])->name('ajax.extras.save');
        Route::get('show', [ExtrasController::class, 'show'])->name('ajax.extras.show');
        Route::post('delete', [ExtrasController::class, 'delete'])->name('ajax.extras.delete');
    });

    Route::prefix('room-use-types')->group(function () {
        Route::get('index', [RoomUseTypesController::class, 'index'])->name('ajax.room-use-types.index');
        Route::post('save', [RoomUseTypesController::class, 'save'])->name('ajax.room-use-types.save');
        Route::get('show', [RoomUseTypesController::class, 'show'])->name('ajax.room-use-types.show');
        Route::post('delete', [RoomUseTypesController::class, 'delete'])->name('ajax.room-use-types.delete');
    });

    Route::prefix('room-statuses')->group(function () {
        Route::get('index', [RoomStatusesController::class, 'index'])->name('ajax.room-statuses.index');
    });

    Route::prefix('rooms')->group(function () {
        Route::get('index', [RoomsController::class, 'index'])->name('ajax.rooms.index');
        Route::post('save', [RoomsController::class, 'save'])->name('ajax.rooms.save');
        Route::get('show', [RoomsController::class, 'show'])->name('ajax.rooms.show');
        Route::post('delete', [RoomsController::class, 'delete'])->name('ajax.rooms.delete');
        Route::get('getRoomsByPanTypeAndRoomType', [RoomsController::class, 'getRoomsByPanTypeAndRoomType'])->name('ajax.rooms.getRoomsByPanTypeAndRoomType');
        Route::get('getRoomsByParameters', [RoomsController::class, 'getRoomsByParameters'])->name('ajax.rooms.getRoomsByParameters');
        Route::post('setRoomStatus', [RoomsController::class, 'setRoomStatus'])->name('ajax.rooms.setRoomStatus');
        Route::post('setRoomPriceCollective', [RoomsController::class, 'setRoomPriceCollective'])->name('ajax.rooms.setRoomPriceCollective');
        Route::post('setRoomStatusCollective', [RoomsController::class, 'setRoomStatusCollective'])->name('ajax.rooms.setRoomStatusCollective');
    });

    Route::prefix('reservations')->group(function () {
        Route::any('index', [ReservationsController::class, 'index'])->name('ajax.reservations.index');
        Route::any('exceptIndex', [ReservationsController::class, 'exceptIndex'])->name('ajax.reservations.exceptIndex');
        Route::any('calendar', [ReservationsController::class, 'calendar'])->name('ajax.reservations.calendar');
        Route::any('edit', [ReservationsController::class, 'edit'])->name('ajax.reservations.edit');
        Route::any('save', [ReservationsController::class, 'save'])->name('ajax.reservations.save');
        Route::any('setStatus', [ReservationsController::class, 'setStatus'])->name('ajax.reservations.setStatus');
        Route::any('endWithWaitingPayment', [ReservationsController::class, 'endWithWaitingPayment'])->name('ajax.reservations.endWithWaitingPayment');
        Route::any('debtControl', [ReservationsController::class, 'debtControl'])->name('ajax.reservations.debtControl');
        Route::any('safeActivities', [ReservationsController::class, 'safeActivities'])->name('ajax.reservations.safeActivities');
        Route::any('transferExtrasAndSafeActivities', [ReservationsController::class, 'transferExtrasAndSafeActivities'])->name('ajax.reservations.transferExtrasAndSafeActivities');
    });

    Route::prefix('hand-overs')->group(function () {
        Route::get('datatable', [HandOversController::class, 'datatable'])->name('ajax.hand-overs.datatable');
    });

    Route::prefix('day-ends')->group(function () {
        Route::get('datatable', [DayEndsController::class, 'datatable'])->name('ajax.day-ends.datatable');
        Route::get('receipts', [DayEndsController::class, 'receipts'])->name('ajax.day-ends.receipts');
    });

    Route::prefix('receipts')->group(function () {
        Route::any('index', [ReceiptsController::class, 'index'])->name('ajax.receipts.index');
        Route::any('save', [ReceiptsController::class, 'save'])->name('ajax.receipts.save');
        Route::any('receiptsByDate', [ReceiptsController::class, 'receiptsByDate'])->name('ajax.receipts.receiptsByDate');
        Route::any('safeTotal', [ReceiptsController::class, 'safeTotal'])->name('ajax.receipts.safeTotal');

        Route::get('dayEndWaitingReceiptsForHandOver', [ReceiptsController::class, 'dayEndWaitingReceiptsForHandOver'])->name('ajax.receipts.dayEndWaitingReceiptsForHandOver');
        Route::get('dayEndWaitingReceiptsForDayEnd', [ReceiptsController::class, 'dayEndWaitingReceiptsForDayEnd'])->name('ajax.receipts.dayEndWaitingReceiptsForDayEnd');
        Route::post('handOver', [ReceiptsController::class, 'handOver'])->name('ajax.receipts.handOver');
        Route::post('dayEnd', [ReceiptsController::class, 'dayEnd'])->name('ajax.receipts.dayEnd');
    });

    Route::prefix('waiting-payments')->group(function () {
        Route::any('index', [WaitingPaymentsController::class, 'index'])->name('ajax.waiting-payments.index');
        Route::post('getPayment', [WaitingPaymentsController::class, 'getPayment'])->name('ajax.waiting-payments.getPayment');
    });

    Route::prefix('stayers')->group(function () {
        Route::any('index', [StayersController::class, 'reservations'])->name('ajax.stayers.reservations');
    });

    Route::prefix('safe-activities')->group(function () {
        Route::post('create', [SafeActivitiesController::class, 'create'])->name('ajax.safe-activities.create');
        Route::any('getPayment', [SafesController::class, 'getPayment'])->name('ajax.safe-activities.getPayment');
        Route::any('refund', [SafesController::class, 'refund'])->name('ajax.safe-activities.refund');
        Route::any('discount', [SafesController::class, 'discount'])->name('ajax.safe-activities.discount');
        Route::any('setDailyRoomPrice', [SafesController::class, 'setDailyRoomPrice'])->name('ajax.safe-activities.setDailyRoomPrice');
        Route::get('getByReservationId', [SafeActivitiesController::class, 'getByReservationId'])->name('ajax.safe-activities.getByReservationId');
    });

    Route::prefix('role')->group(function () {
        Route::post('permissionsUpdate', [RoleController::class, 'permissionsUpdate'])->name('ajax.role.permissionsUpdate');
    });

    Route::prefix('user')->group(function () {
        Route::get('index', [UserController::class, 'index'])->name('ajax.user.index');
        Route::get('show', [UserController::class, 'show'])->name('ajax.user.show');
        Route::post('save', [UserController::class, 'save'])->name('ajax.user.save');
        Route::delete('delete', [UserController::class, 'delete'])->name('ajax.user.delete');
        Route::post('emailControl', [UserController::class, 'emailControl'])->name('ajax.user.emailControl');
    });

    Route::prefix('setting')->group(function () {
        Route::post('setNight', [SettingsController::class, 'setNight'])->name('ajax.setting.setNight');
    });

    Route::prefix('profile')->group(function () {
        Route::post('updateProfile', [ProfileController::class, 'updateProfile'])->name('ajax.profile.updateProfile');
        Route::post('updatePassword', [ProfileController::class, 'updatePassword'])->name('ajax.profile.updatePassword');
    });
});
