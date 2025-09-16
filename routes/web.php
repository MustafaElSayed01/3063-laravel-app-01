<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('init', function () {
    $models = [
        'User',
        'ReactionType',
        'PostStatus',
        'Post',
        'Comment',
        'Reply',
        'Reaction',
    ];
    foreach ($models as $model) {
        Artisan::call('make:model', ['name' => $model, '-a' => true]);
        sleep(1);
    }
});

Route::view('about', 'static.about');

Route::view('contact-us', 'static.contact');

Route::redirect('contact', 'contact-us', 301);

Route::view('privacy-policy', 'static.privacy-policy');

Route::resource('customers', CustomerController::class);

Route::resource('users', UserController::class);

Route::fallback(fn() => abort(404));