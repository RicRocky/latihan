<?php

require __DIR__ . '/auth.php';
use App\Http\Controllers\CryptController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', "verified"])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Item
    Route::get("/inventory/aktif", [ItemController::class, "aktif"])->name("inventory.aktif");
    Route::post("/inventory/aktif-process", [ItemController::class, "aktifProcess"])->name("inventory.aktif-process");
    Route::post("/inventory/cetak", [ItemController::class, "cetak"])->name("inventory.cetak");
    Route::resource('/inventory', ItemController::class)->parameters(['inventory' => 'item']);
    
    // Gudang
    Route::resource('/gudang', GudangController::class);

    Route::get("/profile", [UserController::class, "profile"])->name("profile");
    Route::post("/edit-avatar", [UserController::class, "editAvatar"])->name("edit-avatar");

    Route::post("kirim-pesan", [GudangController::class, "kirimPesan"])->name("kirim-pesan");
});

Route::get("/crypt", [CryptController::class, "index"]);