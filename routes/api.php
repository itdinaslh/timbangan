<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/json/table/show', [APIController::class, 'tableshowunduh'])->name('tblunduh');
Route::get('/json/rfid', [APIController::class, 'rfid'])->name('jsonrfid');
Route::post('/android/auth/savetb', [APIController::class, 'titik_buang'])->name('titikbuang');
Route::get('/android/jenis', [APIController::class, 'jenis'])->name('jenis');
Route::get('/json/update_log', [APIController::class, 'update_log'])->name('ul');
Route::get('/android/location', [APIController::class, 'location'])->name('location');
// Route::get('/json/truck', [APIController::class, 'truck'])->name('jsontruck');
Route::get('/json/door/manipulate', [APIController::class, 'apidoor'])->name('jsondoorm');
Route::get('/json/truck/manipulate', [APIController::class, 'apitruck'])->name('jsontruck');
Route::post('/json/truck/getdoor', [APIController::class, 'gettruckbydoor'])->name('jsontruckdoor');
Route::get('/json/door', [APIController::class, 'pintu'])->name('jsondoor');
Route::get('/json/ekspenditur', [APIController::class, 'ekspenditur'])->name('jsonekspenditur');
Route::get('/json/areacek', [APIController::class, 'wilayah'])->name('areaapi');
Route::post('/json/area', [APIController::class, 'getjumlah'])->name('getjumlah');
Route::post('/json/getabsen', [APIController::class, 'showabsen'])->name('showabsen');
Route::post('/json/getsama', [APIController::class, 'getsama'])->name('getsama');
Route::post('/json/getnett', [APIController::class, 'getnett'])->name('getnett');
Route::post('/json/getritase', [APIController::class, 'getritase'])->name('getritase');
Route::post('/json/getritases', [APIController::class, 'getritases'])->name('getritases');
Route::post('/json/gettonases', [APIController::class, 'gettonases'])->name('gettonases');
Route::post('/hapustransaksi', [APIController::class, 'hapustransaksi'])->name('hts');
Route::post('/getlastidp', [APIController::class, 'getlastidp'])->name('getlastidp');
Route::post('/getlastidmk', [APIController::class, 'getlastidmk'])->name('getlastidmk');
Route::post('/getlastidspj', [APIController::class, 'getlastidspj'])->name('getlastidspj');
Route::post('/get/ritasetonase', [APIController::class, 'getrittonase'])->name('getrittonase');
Route::post('/get/doubleritase', [APIController::class, 'doubleritase'])->name('getdoubleritase');
Route::get('/get/showdisplay/{type}', [APIController::class, 'showdisplay'])->name('showdisplay');
Route::post('/getper', [APIController::class, 'getper'])->name('getper');


Route::post('gettransaksi', [APIController::class, 'daftartransaksi'])->name('gettransaksi');
Route::post('/simpanauto/masuk',[APIController::class, 'simpanauto'])->name('saveauto');
Route::get('/print/ulang', [APIController::class, 'printulang'])->name('printu');
Route::get('/listtimbangmasuk', [APIController::class, 'listtimbangmasuk'])->name('listmasuk');
Route::get('/listtimbangkeluar', [APIController::class, 'listtimbangkeluar'])->name('listkeluar');
Route::post('/simpanauto/keluar', [APIController::class, 'simpanauto2'])->name('saveauto2');
Route::get('/setting', [APIController::class, 'settingmanualauto'])->name('sm');
Route::post('/jumlahzona', [APIController::class, 'jumlahzona'])->name('jz');
Route::post('/totalzona', [APIController::class, 'totalzona'])->name('tz');
Route::post('/android/auth/login', [APIController::class, 'logincheck'])->name('logincheck');
Route::post('/dwellingtime', [APIController::class, 'dwellingtime'])->name('dt');
//Updated 22-10-2019
//

Route::get('/android/ritzona', [APIController::class, 'ritasezona'])->name('rz');
Route::get('/android/dwellzona', [APIController::class, 'dwellingzona'])->name('dz');
