<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('about', 'static.about');

Route::view('contact-us', 'static.contact');

Route::redirect('contact', 'contact-us', 301);

Route::view('privacy-policy', 'static.privacy-policy');


Route::prefix('customers')->group(function () {
    Route::get('/', function () {
        $customers = [
            ['name' => 'Hassan Mahmoud', 'city' => 'Cairo', 'country' => 'Egypt', 'phone' => '01000000000'],
            ['name' => 'Ahmed Ali', 'city' => 'Alex', 'country' => 'Egypt', 'phone' => '01000000001'],
            ['name' => 'Eman Ahmed', 'city' => 'Giza', 'country' => 'Egypt', 'phone' => '01000000002'],
            ['name' => 'Jailan Yousef', 'city' => 'Giza', 'country' => 'Egypt', 'phone' => '01000000002'],
            ['name' => 'Yara Mostafa', 'city' => 'Cairo', 'country' => 'Egypt', 'phone' => '01000000003'],
            ['name' => 'Maged Ali', 'city' => 'Alex', 'country' => 'Egypt', 'phone' => '01000000004'],
            ['name' => 'Ali Ibrahim', 'city' => 'Giza', 'country' => 'Egypt', 'phone' => '01000000005'],
            ['name' => 'Hassan Ali', 'city' => 'Cairo', 'country' => 'Egypt', 'phone' => '01000000006'],
            ['name' => 'Mohamed Ahmed', 'city' => 'Alex', 'country' => 'Egypt', 'phone' => '01000000007'],
        ];

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
});

Route::prefix('/users')->group(function () {
    Route::get('/', function () {
        $users = [
            ['name' => 'John Doe', 'email' => 'johndoe@example.com', 'phone' => '01000000000', 'role' => 'admin'],
            ['name' => 'Jane Doe', 'email' => 'janedoe@example.com', 'phone' => '01000000001', 'role' => 'user'],
            ['name' => 'Alice Smith', 'email' => 'alicesmith@example.com', 'phone' => '01000000002', 'role' => 'manager'],
            ['name' => 'Bob Johnson', 'email' => 'bobjohnson@example.com', 'phone' => '01000000003', 'role' => 'user'],
        ];
        return view('users.index', compact('users'));
    });

    Route::get('/create', fn() => view('users.create'));
    Route::get('/show/{user}', fn($user) => view('users.show', ['user' => $user]))->whereNumber('user');
    Route::get('/edit/{user}', fn($user) => view('users.edit', ['user' => $user]))->whereNumber('user');
    Route::get('/delete/{user}', fn($user) => "Delete User $user")->whereNumber('user');
    Route::get('/role/{role}', fn($role) => "Users with role: $role")->whereIn('role', ['admin', 'user', 'guest', 'manager']);
});
Route::fallback(fn() => abort(404));