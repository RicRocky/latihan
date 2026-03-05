<?php

require __DIR__ . '/auth.php';
use App\Http\Controllers\CryptController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\UserController as AdminUserController;

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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['auth', 'verified'])->group(function () {
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Item
    Route::get("/inventory/aktif", [ItemController::class, "aktif"])->name("inventory.aktif");
    Route::post("/inventory/aktif-process", [ItemController::class, "aktifProcess"])->name("inventory.aktif-process");
    Route::post("/inventory/cetak", [ItemController::class, "cetak"])->name("inventory.cetak");
    Route::get("/inventory/detail/{item}", [ItemController::class, "detail"])->name("inventory.detail");
    Route::resource('/inventory', ItemController::class)->parameters(['inventory' => 'item']);

    // Gudang
    Route::resource('/gudang', GudangController::class);
    Route::post("kirim-pesan", [GudangController::class, "kirimPesan"])->name("kirim-pesan");

    // Supplier
    Route::resource("/supplier", SupplierController::class);

    // Item Supplier
    Route::post("/item-supplier", [ItemController::class, "addItemSupplier"])->name("inventory.supplier");

    //User
    Route::get("/users", [UserController::class, "index"])->name("user.index");
    Route::get("/users/{user}", [UserController::class, "edit"])->name("user.edit");
    Route::put("/users/{user}", [UserController::class, "update"])->name("user.update");

    // Profile
    Route::get("/profile", [UserController::class, "profile"])->name("profile");
    Route::post("/edit-avatar", [UserController::class, "editAvatar"])->name("edit-avatar");
    Route::post("/get-alamat", [UserController::class, "getAlamat"])->name("get-alamat");
});

Route::get("/crypt", [CryptController::class, "index"]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get("/admin/dashboard", function () {
        return view("adminlte.dashboard");
    })->name("admin.dashboard");

    // User
    Route::get("/admin/user/index", [AdminUserController::class, "index"])->name("admin.users");
    Route::delete("/admin/user/delete", [AdminUserController::class, "delete"])->name("admin.user.delete");

});