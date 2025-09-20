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

Route::view('privacy-policy', 'static.privacy-policy');

Route::fallback(fn() => abort(404));
