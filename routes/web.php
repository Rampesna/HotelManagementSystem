<?php

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test', function () {
    $startDate = '2021-05-02 15:00:00';
    $endDate = '2021-05-07 15:00:00';

    $reservations = Reservation::
    where(function ($dates) use ($startDate, $endDate) {
        $dates->where(function ($forStartDate) use ($startDate, $endDate) {
            $forStartDate->where('start_date', '<=', $startDate)->where('end_date', '>=', $startDate);
        })->
        orWhere(function ($forEndDate) use ($startDate, $endDate) {
            $forEndDate->where('start_date', '<=', $endDate)->where('end_date', '>=', $endDate);
        });
    })->
    whereIn('status_id', [1, 2, 4])->
    pluck('id');

    return $reservations;
});

Auth::routes();

Route::get('/', function () {
    return redirect()->route('management.dashboard.index');
});
Route::middleware(['auth'])->namespace('App\\Http\\Controllers')->group(function () {
    Route::prefix('management')->namespace('Management')->group(function () {

        Route::prefix('dashboard')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.dashboard.index');
            });
            Route::get('index', 'DashboardController@index')->name('management.dashboard.index')->middleware('Authority:1');
        });

        Route::prefix('reservation')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.reservation.index');
            });
            Route::get('index', 'ReservationController@index')->name('management.reservation.index')->middleware('Authority:1');
            Route::get('downloadInvoice', 'ReservationController@downloadInvoice')->name('management.reservation.downloadInvoice')->middleware('Authority:1');
        });

        Route::prefix('safe')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.safe.index');
            });
            Route::get('index', 'SafeController@index')->name('management.safe.index')->middleware('Authority:1');
        });

        Route::prefix('stayer')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.stayer.index');
            });
            Route::get('index', 'StayerController@index')->name('management.stayer.index')->middleware('Authority:1');
        });

        Route::prefix('room')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.room.index');
            });
            Route::get('index', 'RoomController@index')->name('management.room.index')->middleware('Authority:1');
        });
    });
});
