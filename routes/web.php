<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('models_init', function () {
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

Route::get('resources_init', function () {

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
        Artisan::call('make:resource', ['name' => $model.'Resource']);
        Artisan::call('make:resource', ['name' => $model.'Collection']);
    }
});

Route::view('about', 'static.about');

Route::view('contact-us', 'static.contact');

Route::view('privacy-policy', 'static.privacy-policy');

Route::fallback(fn () => abort(404));
