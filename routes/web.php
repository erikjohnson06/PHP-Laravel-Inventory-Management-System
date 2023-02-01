<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PoS\CategoryController;
use App\Http\Controllers\PoS\CustomerController;
use App\Http\Controllers\PoS\InvoiceController;
use App\Http\Controllers\PoS\JSController;
use App\Http\Controllers\PoS\ProductController;
use App\Http\Controllers\PoS\PurchaseOrderController;
use App\Http\Controllers\PoS\SupplierController;
use App\Http\Controllers\PoS\UnitController;
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
        Route::get('/supplier/edit/{id}', 'viewEditSupplier')->name('supplier.edit');
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

    Route::controller(ProductController::class)->group(function () {
        Route::get('/products/all', 'viewProductsAll')->name('products.all');
        Route::get('/product/add', 'viewAddProduct')->name('product.add');
        Route::get('/product/edit/{id}', 'viewEditProduct')->name('product.edit');
        Route::get('/product/delete/{id}', 'deleteProduct')->name('product.delete');
        Route::post('/product/store', 'addProduct')->name('store.product');
        Route::post('/product/update', 'updateProduct')->name('update.product');
    });

    Route::controller(UnitController::class)->group(function () {
        Route::get('/units/all', 'viewUnitsAll')->name('units.all');
        Route::get('/unit/add', 'viewAddUnit')->name('unit.add');
        Route::get('/unit/edit/{id}', 'viewEditUnit')->name('unit.edit');
        Route::get('/unit/delete/{id}', 'deleteUnit')->name('unit.delete');
        Route::post('/unit/store', 'addUnit')->name('store.unit');
        Route::post('/unit/update', 'updateUnit')->name('update.unit');
    });

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/categories/all', 'viewCategoriesAll')->name('categories.all');
        Route::get('/category/add', 'viewAddCategory')->name('category.add');
        Route::get('/category/edit/{id}', 'viewEditCategory')->name('category.edit');
        Route::get('/category/delete/{id}', 'deleteCategory')->name('category.delete');
        Route::post('/category/store', 'addCategory')->name('store.category');
        Route::post('/category/update', 'updateCategory')->name('update.category');
    });

    Route::controller(PurchaseOrderController::class)->group(function () {
        Route::get('/purchaseorders/all', 'viewPurchaseOrdersAll')->name('purchaseorders.all');
        Route::get('/purchaseorders/approval', 'viewPurchaseOrdersApproval')->name('purchaseorder.approval');
        Route::get('/purchaseorders/approve/{id}', 'approvePurchaseOrder')->name('purchaseorder.approve');
        Route::get('/purchaseorder/create', 'viewAddPurchaseOrder')->name('purchaseorder.add');
        Route::get('/purchaseorder/delete/{id}', 'deletePurchaseOrder')->name('purchaseorder.delete');
        Route::get('/purchaseorder/cancel/{id}', 'cancelPurchaseOrder')->name('purchaseorder.cancel');
        Route::post('/purchaseorder/store', 'createPurchaseOrder')->name('store.purchaseorder');
    });

    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoices/all', 'viewInvoicesAll')->name('invoices.all');
        Route::get('/invoices/pending', 'viewInvoicesPEnding')->name('invoices.pending');
        Route::get('/invoice/create', 'viewAddInvoice')->name('invoice.add');
        Route::post('/invoice/store', 'createInvoice')->name('store.invoice');
        Route::get('/invoice/delete/{id}', 'deleteInvoice')->name('invoice.delete');
        Route::get('/invoice/approval/{id}', 'viewApproveInvoice')->name('invoice.approval');
    });

    Route::controller(JSController::class)->group(function () {
        Route::get('/get-categories-by-supplier', 'getCategoriesBySupplierId')->name('get-categories-by-supplier');
        Route::get('/get-products-by-supplier-and-category', 'getProductsByCategoriesAndSupplierId')->name('get-products-by-supplier-and-category');
        Route::get('/get-products-by-category', 'getProductsByCategoryId')->name('get-products-by-category');
        Route::get('/get-product-available-qty', 'getProductAvailableQty')->name('get-product-available-qty');
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
