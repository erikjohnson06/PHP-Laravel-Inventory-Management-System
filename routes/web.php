<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PoS\SupplierController;
use App\Http\Controllers\PoS\CustomerController;
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
})->name('home');

Route::middleware(['auth'])->group(function(){

    Route::controller(AdminController::class)->group(function () {

        Route::get('/admin/logout', 'destroy')->name('admin.logout');

        Route::get('/admin/profile', 'profile')->name('admin.profile');
        Route::get('/edit/profile', 'editProfile')->name('edit.profile');
        Route::post('/store/profile', 'storeProfile')->name('store.profile');

        Route::get('/update/password', 'updatePassword')->name('update.password');
        Route::post('/store/password', 'storePassword')->name('store.password');
    });

    Route::controller(SupplierController::class)->group(function () {
        Route::get('/suppliers/all', 'viewSuppliersAll')->name('suppliers.all');
        Route::get('/supplier/add', 'viewAddSupplier')->name('supplier.add');
        Route::get('/supplier/edit/{id}', 'editSupplier')->name('supplier.edit');
        Route::get('/supplier/delete/{id}', 'deleteSupplier')->name('supplier.delete');
        Route::post('/supplier/store', 'addSupplier')->name('store.supplier');
        Route::post('/supplier/update', 'updateSupplier')->name('update.supplier');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/customers/all', 'viewCustomersAll')->name('customers.all');
        Route::get('/customer/add', 'viewAddCustomer')->name('customer.add');
        Route::get('/customer/edit/{id}', 'viewEditCustomer')->name('customer.edit');
        Route::get('/customer/delete/{id}', 'deleteCustomer')->name('customer.delete');
        Route::post('/customer/store', 'addCustomer')->name('store.customer');
        Route::post('/customer/update', 'updateCustomer')->name('update.customer');
    });
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
