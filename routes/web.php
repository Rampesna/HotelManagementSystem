<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Management\DashboardController;
use App\Http\Controllers\Management\ReservationController;
use App\Http\Controllers\Management\SafeController;
use App\Http\Controllers\Management\HandOverController;
use App\Http\Controllers\Management\DayEndController;
use App\Http\Controllers\Management\ReceiptController;
use App\Http\Controllers\Management\WaitingPaymentController;
use App\Http\Controllers\Management\StayerController;
use App\Http\Controllers\Management\RoomController;
use App\Http\Controllers\Management\CustomerController;
use App\Http\Controllers\Management\CompanyController;
use App\Http\Controllers\Management\ProfileController;
use App\Http\Controllers\Management\Definition\DefinitionController;
use App\Http\Controllers\Management\Definition\RoomController as DefinitionRoomController;
use App\Http\Controllers\Management\Definition\RoomTypeController;
use App\Http\Controllers\Management\Definition\PanTypeController;
use App\Http\Controllers\Management\Definition\RoomUseTypeController;
use App\Http\Controllers\Management\Definition\ExtraController;
use App\Http\Controllers\Management\SettingController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\Management\UserController;

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

});

Auth::routes();

Route::get('/', function () {
    return redirect()->route('management.dashboard.index');
});
Route::middleware(['auth'])->group(function () {
    Route::prefix('management')->group(function () {

        Route::prefix('dashboard')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.dashboard.index');
            });
            Route::get('index', [DashboardController::class, 'index'])->name('management.dashboard.index')->middleware('Authority:1');
        });

        Route::prefix('reservation')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.reservation.index');
            });
            Route::get('index', [ReservationController::class, 'index'])->name('management.reservation.index')->middleware('Authority:2');
            Route::get('downloadInvoice', [ReservationController::class, 'downloadInvoice'])->name('management.reservation.downloadInvoice')->middleware('Authority:2');
        });

        Route::prefix('safe')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.safe.index');
            });
            Route::get('index', [SafeController::class, 'index'])->name('management.safe.index')->middleware('Authority:19');
        });

        Route::prefix('hand-over')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.hand-over.index');
            });
            Route::get('index', [HandOverController::class, 'index'])->name('management.hand-over.index')->middleware('Authority:32');
        });

        Route::prefix('day-end')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.day-end.index');
            });
            Route::get('index', [DayEndController::class, 'index'])->name('management.day-end.index')->middleware('Authority:33');
        });

        Route::prefix('receipt')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.receipt.index');
            });
            Route::get('index', [ReceiptController::class, 'index'])->name('management.receipt.index')->middleware('Authority:20');
        });

        Route::prefix('waiting-payment')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.waiting-payment.index');
            });
            Route::get('index', [WaitingPaymentController::class, 'index'])->name('management.waiting-payment.index')->middleware('Authority:23');
        });

        Route::prefix('stayer')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.stayer.index');
            });
            Route::get('index', [StayerController::class, 'index'])->name('management.stayer.index')->middleware('Authority:10');
        });

        Route::prefix('room')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.room.index');
            });
            Route::get('index', [RoomController::class, 'index'])->name('management.room.index')->middleware('Authority:11');
        });

        Route::prefix('customers')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.customers.index');
            });
            Route::get('index', [CustomerController::class, 'index'])->name('management.customers.index')->middleware('Authority:25');
        });

        Route::prefix('companies')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.companies.index');
            });
            Route::get('index', [CompanyController::class, 'index'])->name('management.companies.index')->middleware('Authority:26');
        });

        Route::prefix('profile')->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.profile.index');
            });
            Route::get('index', [ProfileController::class, 'index'])->name('management.profile.index');
        });

        Route::prefix('definitions')->middleware(['Authority:18'])->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.definitions.index');
            });
            Route::get('index', [DefinitionController::class, 'index'])->name('management.definitions.index')->middleware('Authority:1');

            Route::prefix('room')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.room.index');
                });
                Route::get('index', [DefinitionRoomController::class, 'index'])->name('management.definitions.room.index')->middleware('Authority:1');
            });

            Route::prefix('room-type')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.room-type.index');
                });
                Route::get('index', [RoomTypeController::class, 'index'])->name('management.definitions.room-type.index')->middleware('Authority:1');
            });

            Route::prefix('pan-type')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.pan-type.index');
                });
                Route::get('index', [PanTypeController::class, 'index'])->name('management.definitions.pan-type.index')->middleware('Authority:1');
            });

            Route::prefix('room-use-type')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.room-use-type.index');
                });
                Route::get('index', [RoomUseTypeController::class, 'index'])->name('management.definitions.room-use-type.index')->middleware('Authority:1');
            });

            Route::prefix('extra')->group(function () {
                Route::get('/', function () {
                    return redirect()->route('management.definitions.extra.index');
                });
                Route::get('index', [ExtraController::class, 'index'])->name('management.definitions.extra.index')->middleware('Authority:1');
            });
        });

        Route::prefix('setting')->group(function () {
            Route::get('index', [SettingController::class, 'index'])->name('management.setting.index');
        });

        Route::prefix('roles')->middleware(['Authority:28'])->group(function () {
            Route::get('/', function () {
                return redirect()->route('management.roles.index');
            });
            Route::get('index', [RoleController::class, 'index'])->name('management.roles.index')->middleware('Authority:1');
            Route::post('/store', [RoleController::class, 'store'])->name('setting.roles.store');
            Route::get('/edit', [RoleController::class, 'edit'])->name('setting.roles.edit');
            Route::get('/permissions', [RoleController::class, 'permissions'])->name('setting.roles.permissions');
            Route::post('/permissions/update', [RoleController::class, 'permissionsUpdate'])->name('setting.roles.permissions.update');
            Route::post('/update', [RoleController::class, 'update'])->name('setting.roles.update');
            Route::post('/delete', [RoleController::class, 'delete'])->name('setting.roles.delete');
        });

        Route::prefix('users')->middleware(['Authority:29'])->group(function () {
            Route::get('/', function () {
                return redirect()->route('setting.users.index');
            });
            Route::get('/index', [UserController::class, 'index'])->name('management.users.index');
            Route::post('/save', [UserController::class, 'save'])->name('management.users.save');
            Route::get('/edit', [UserController::class, 'edit'])->name('management.users.edit');
            Route::post('/delete', [UserController::class, 'delete'])->name('management.users.delete');
        });
    });
});
