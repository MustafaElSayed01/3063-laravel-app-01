<?php

use App\Http\Controllers\{
    AuthController,
    CommentController,
    PostController,
    ReactionController,
    ReplyController,
    UserController
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Welcome  API';
});

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('web-login', 'web_login');
    Route::post('mobile-login', 'mobile_login');
    Route::post('register', 'register');
});


Route::middleware(['auth:sanctum'])->group(function () {

    // Posts, comments, reactions, users, replies
    Route::apiResources(
        [
            'posts' => PostController::class,
            'comments' => CommentController::class,
            'replies' => ReplyController::class,
            'users' => UserController::class,
            'reactions' => ReactionController::class,
        ]
    );

    // Auth
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        // All Sessions
        Route::get('active-sessions', 'active_sessions');

        // logout
        Route::prefix('logout')->group(function () {
            Route::post('all', 'logout_all');
            Route::post('current', 'logout_current');
            Route::post('others', 'logout_others');
            Route::post('session/{id}', 'logout_session');
        });
        // Profile

        Route::prefix('profile')->group(function () {
            Route::get('', 'show_profile');
            Route::put('', 'update_profile');
            Route::put('change-photo', 'change_photo');
        });

        // Change password
        Route::put('change-password', 'change_password');
    });
});
