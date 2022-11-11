<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StruckController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\EkspenditurController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\InfoController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('/', function () {
    return view('index');
});

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/home', [AdminController::class, 'AdminDashboard'])->name('home');

    //info
    Route::get('/info_truck', [InfoController::class, 'truck']);
    Route::get('/info_ekspenditur', [InfoController::class, 'ekspenditur']);
    Route::get('/list_group', [InfoController::class, 'list_group']);
    Route::get('/cek_absen', [InfoController::class, 'cek_absen']);
    Route::get('/login_history', [InfoController::class, 'login_history']);

    //permission
    Route::get('/permission', [PermissionController::class, 'index']);
    Route::get('/permission/add/', [PermissionController::class, 'Add']);
    Route::get('/permission/edit/{id}', [PermissionController::class, 'Edit']);
    Route::post('/permission/store', [PermissionController::class, 'store']);
    Route::post('/permission/delete/{id}', [PermissionController::class, 'delete']);

    Route::get('/dashboard', [AdminController::class, 'AdminDashboard']);

    //operator timbangan masuk
    Route::get('/timbangan/get', [AdminController::class, 'getdoorid'])->name('getdoor');
    Route::get('/timbangan/getberat', [AdminController::class, 'getberat'])->name('getberat');
    Route::get('/timbangan/socket/{type}', [AdminController::class, 'socket'])->name('socket');
    Route::post('/timbangan/absen', [AdminController::class, 'simpanabsensi'])->name('absensi');
    Route::get('/timbangan/masuk/store', [AdminController::class, 'storetm'])->name('storetm');

    //operator timbangan keluar
    Route::post('/timbangan/cek', [AdminController::class, 'checkdoor'])->name('checkdoor');
    Route::get('/timbangan/keluar/store', [AdminController::class, 'storetk'])->name('storetk');

    Route::get('/setting', [HomeController::class, 'setting']);
    Route::post('/setting/store', [HomeController::class, 'settingstore']);
    //struck
    Route::get('/edit_transaksi', [StruckController::class, 'index']);
    Route::get('/edit_transaksi/add', [StruckController::class, 'Add']);
    Route::get('/edit_transaksi/edit/{id}', [StruckController::class, 'Edit']);
    Route::post('/edit_transaksi/store', [StruckController::class, 'store']);
    Route::post('/edit_transaksi/delete/{id}', [StruckController::class, 'delete']);

    //truck
    Route::get('/data_truk', [TruckController::class, 'index']);
    Route::get('/data_truk/add/', [TruckController::class, 'Add']);
    Route::get('/data_truk/edit/{id}', [TruckController::class, 'Edit']);
    Route::post('/data_truk/store', [TruckController::class, 'store']);
    Route::post('/data_truk/delete/{id}', [TruckController::class, 'delete']);
    Route::get('/data_truk/table', [TruckController::class, 'Ajax']);
    Route::get('/data_truk/search', [TruckController::class, 'search']);
    Route::get('/data_truk/data', [TruckController::class, 'export']);

    //truck
    Route::get('/data_ekspenditur', [EkspenditurController::class, 'index']);
    Route::get('/data_ekspenditur/add/', [EkspenditurController::class, 'Add']);
    Route::get('/data_ekspenditur/edit/{id}', [EkspenditurController::class, 'Edit']);
    Route::post('/data_ekspenditur/store', [EkspenditurController::class, 'store']);
    Route::post('/data_ekspenditur/delete/{id}', [EkspenditurController::class, 'delete']);
    Route::get('/data_ekspenditur/search', [EkspenditurController::class, 'search']);

    //truck
    Route::get('/data_user', [UserController::class, 'index']);
    Route::get('/data_user/add', [UserController::class, 'Add']);
    Route::get('/data_user/edit/{id}', [UserController::class, 'Edit']);
    Route::post('/data_user/store', [UserController::class, 'store']);
    Route::post('/data_user/delete/{id}', [UserController::class, 'delete']);
    Route::get('/data_user/table', [UserController::class, 'Ajax']);
    Route::get('/data_user/search', [UserController::class, 'search']);
 

    //Socket Route
    Route::get('/timbangan/socket/{type}', [HomeController::class, 'socket'])->name('socket');
});
