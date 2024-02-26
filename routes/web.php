<?php

use App\Http\Controllers\AdminController;
// use App\Http\Controllers\authController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoorprizeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/foo', function () {
    Artisan::call('storage:link');
    });
Route::get('/', [UserController::class, 'index'])->name('index');
Route::middleware('is.form.filled')->group(function () {
    Route::get('/berhasil', [UserController::class, 'BerhasilRegis'])->name('berhasil.regis');
});
Route::post('/register/do', [UserController::class, 'registerDo'])->name('register.do');

// ADMIN ROUTES
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/do', [AuthCOntroller::class, 'loginDo'])->name('login.do');
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/admin/list-peserta', [AdminController::class, 'listPeserta'])->name('admin.list.peserta');
    Route::get('/admin/list-grup', [AdminController::class, 'listGrup'])->name('admin.list.grup');
   

    Route::post('/admin/grup/add', [AdminController::class, 'grupAdd'])->name('admin.grup.add');
    Route::post('/admin/grup/edit/{id}', [AdminController::class, 'grupEdit'])->name('admin.grup.edit');
    Route::get('/admin/grup/delete/{id}', [AdminController::class, 'grupDelete'])->name('admin.grup.delete');
    Route::get('/admin/grup/generate/{id}', [AdminController::class, 'grupGenerate'])->name('admin.grup.generate');
    Route::post('/admin/grup/generate/do', [AdminController::class, 'grupGenerateDo'])->name('admin.grup.generate.do');
    Route::post('/admin/grup/generate/lock', [AdminController::class, 'grupGenerateLock'])->name('admin.grup.generate.lock');

    Route::get('/admin/list-hadiah', [AdminController::class, 'listHadiah'])->name('admin.list.hadiah');
    Route::post('admin/hadiah/add/do', [AdminController::class, 'hadiahAddDo'])->name('admin.hadiah.add.do');
    Route::post('admin/hadiah/edit/do/{id}', [AdminController::class, 'hadiahEditDo'])->name('admin.hadiah.edit.do');
    Route::get('admin/hadiah/delete/do/{id}', [AdminController::class, 'hadiahDeleteDo'])->name('admin.hadiah.delete.do');
    Route::get('/admin/generate/pemenang/{id}', [AdminController::class, 'generatePemenang'])->name('admin.generate.pemenang');
    Route::post('/admin/generate/pemenang/do', [AdminController::class, 'generatePemenangDo'])->name('admin.generate.pemenang.do');
    Route::post('/lock', [AdminController::class, 'lockPemenang'])->name('admin.lock');


    Route::get('/admin/scan', [AdminController::class, 'scan'])->name('admin.scan');
    Route::post('/admin/scan/do', [AdminController::class, 'scanDo'])->name('admin.scan.do');
    Route::post('/admin/scan/gun/do', [AdminController::class, 'scanGunDo'])->name('admin.scan.gun.do');
    Route::get('/admin/download/{id}', [AdminController::class, 'downloadQr'])->name('admin.download.qr');

    Route::post('users-import', [AdminController::class, 'import'])->name('users.import');
    
    Route::get('/logout/do', [AuthController::class, 'logoutDo'])->name('logout.do');
});

Route::get('/admin/flight/view', [AdminController::class, 'flightView'])->name('admin.flight.view');
Route::get('/button-gen', [DoorprizeController::class, 'buttonGen'])->name('admin.button.generate');
Route::get('/display/view', [DoorprizeController::class, 'displayView'])->name('admin.display.view');
Route::get('/ambil/hadiah', [DoorprizeController::class, 'ambilHadiah'])->name('admin.ambil.hadiah');
Route::get('/display/{id}/{status}', [DoorprizeController::class, 'display'])->name('admin.display');
Route::get('/ambil/display', [DoorprizeController::class, 'ambilDisplay'])->name('admin.ambil.display');
