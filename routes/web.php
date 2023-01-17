<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PoS\SuppliersController;
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

Route::controller(AdminController::class)->group(function () {

    Route::get('/admin/logout', 'destroy')->name('admin.logout');

    Route::get('/admin/profile', 'profile')->name('admin.profile');
    Route::get('/edit/profile', 'editProfile')->name('edit.profile');
    Route::post('/store/profile', 'storeProfile')->name('store.profile');

    Route::get('/update/password', 'updatePassword')->name('update.password');
    Route::post('/store/password', 'storePassword')->name('store.password');
});

Route::controller(SuppliersController::class)->group(function () {
    Route::get('/suppliers/all', 'viewSuppliersAll')->name('suppliers.all');
    Route::get('/suppliers/add', 'viewAddSupplier')->name('suppliers.add');
    Route::get('/suppliers/edit/{id}', 'editSupplier')->name('suppliers.edit');
    Route::get('/suppliers/delete/{id}', 'deleteSupplier')->name('suppliers.delete');
    Route::post('/suppliers/store', 'addSupplier')->name('store.supplier');

});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
