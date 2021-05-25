<?php

use App\Models\Reservation;
use Illuminate\Support\Carbon;
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
    return $period = Carbon::createFromDate('2021-05-24')->diffInDays('2021-05-26');
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

        Route::prefix('receipt')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.receipt.index');
            });
            Route::get('index', 'ReceiptController@index')->name('management.receipt.index')->middleware('Authority:1');
        });

        Route::prefix('waiting-payment')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.waiting-payment.index');
            });
            Route::get('index', 'WaitingPaymentController@index')->name('management.waiting-payment.index')->middleware('Authority:1');
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
            Route::post('getPayment', 'RoomController@getPayment')->name('management.room.getPayment')->middleware('Authority:1');
        });

        Route::prefix('customers')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.customers.index');
            });
            Route::get('index', 'CustomerController@index')->name('management.customers.index')->middleware('Authority:1');
        });

        Route::prefix('companies')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.companies.index');
            });
            Route::get('index', 'CompanyController@index')->name('management.companies.index')->middleware('Authority:1');
        });

        Route::prefix('definitions')->namespace('Definition')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.definitions.index');
            });
            Route::get('index', 'DefinitionController@index')->name('management.definitions.index')->middleware('Authority:1');

            Route::prefix('room')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.room.index');
                });
                Route::get('index', 'RoomController@index')->name('management.definitions.room.index')->middleware('Authority:1');
            });

            Route::prefix('room-type')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.room-type.index');
                });
                Route::get('index', 'RoomTypeController@index')->name('management.definitions.room-type.index')->middleware('Authority:1');
            });

            Route::prefix('pan-type')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.pan-type.index');
                });
                Route::get('index', 'PanTypeController@index')->name('management.definitions.pan-type.index')->middleware('Authority:1');
            });

            Route::prefix('room-use-type')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.room-use-type.index');
                });
                Route::get('index', 'RoomUseTypeController@index')->name('management.definitions.room-use-type.index')->middleware('Authority:1');
            });

            Route::prefix('extra')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.extra.index');
                });
                Route::get('index', 'ExtraController@index')->name('management.definitions.extra.index')->middleware('Authority:1');
            });
        });

        Route::prefix('setting')->group(function () {
            Route::get('index', 'SettingController@index')->name('management.setting.index');
        });

        Route::prefix('roles')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.roles.index');
            });
            Route::get('index', 'RoleController@index')->name('management.roles.index')->middleware('Authority:1');
            Route::post('/store', 'RoleController@store')->name('setting.roles.store');
            Route::get('/edit', 'RoleController@edit')->name('setting.roles.edit');
            Route::get('/permissions', 'RoleController@permissions')->name('setting.roles.permissions');
            Route::post('/permissions/update', 'RoleController@permissionsUpdate')->name('setting.roles.permissions.update');
            Route::post('/update', 'RoleController@update')->name('setting.roles.update');
            Route::post('/delete', 'RoleController@delete')->name('setting.roles.delete');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', function () {
                return redirect()->route('setting.users.index');
            });
            Route::get('/index', 'UserController@index')->name('management.users.index');
            Route::post('/save', 'UserController@save')->name('management.users.save');
            Route::get('/edit', 'UserController@edit')->name('management.users.edit');
            Route::post('/delete', 'UserController@delete')->name('management.users.delete');
        });
    });
});
