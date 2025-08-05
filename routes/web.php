<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('about', 'static.about');

Route::view('contact-us', 'static.contact');

Route::redirect('contact', 'contact-us', 301);

Route::view('privacy-policy', 'static.privacy-policy');

Route::resource('customers', CustomerController::class);

Route::resource('users', UserController::class);

/*Route::prefix('customers')->group(function () {
    Route::get('/', function () {

        return view('customers.index', compact('customers'));
    });

    Route::get('{customer}', function ($customer) {
        return "Customer $customer Page";
    });

    Route::get('{customer}/edit', function ($customer) {
        return "Update Customer $customer";
    });

    Route::get('{customer}/categories/{category}', function ($customer, $category) {
        return "View $category for Customer $customer";
    })->whereNumber('customer')->whereAlphaNumeric('category');

    Route::get('{customer}/category_id/{category}', function ($customer, $category) {
        return "Customer $customer: Categoris with ID $category";
    })->whereNumber(['customer', 'category']);

    Route::get('branch/{branch}', function ($branch) {
        return "Customers in $branch Branch";
    })->whereIn('branch', ['cairo', 'alex', 'giza']);

    Route::get('by-code/{code}', function () {
        return 'Customers by Code';
    })->where('code', '[a-z]{3}-[\d]{3}');
});*/

/*Route::prefix('/users')->group(function () {

    Route::get('/', [UserController::class, 'index']);
    Route::get('/create', [UserController::class, 'create']);
    Route::get('/show/{user}', [UserController::class, 'show'])->whereNumber('user');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->whereNumber('user');
    Route::get('/delete/{user}', [UserController::class, 'destroy'])->whereNumber('user');
    Route::get('/role/{role}', [UserController::class, 'role'])->whereIn('role', ['admin', 'user', 'guest', 'manager']);
});*/
Route::fallback(fn() => abort(404));