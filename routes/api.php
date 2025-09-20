<?php

use App\Http\Controllers\{
    AuthController,
    CommentController,
    PostController,
    PostStatusController,
    ReactionController,
    ReactionTypeController,
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

    // Posts
    Route::prefix('posts')->controller(PostController::class)->group(function () {
        Route::get('sample', 'random');
        Route::get('deleted', 'deleted');
        Route::get('restore/{id}', 'restore');
        Route::delete('hard-delete/{id}', 'hard_delete');
    });

    // Comments
    Route::prefix('comments')->controller(CommentController::class)->group(function () {
        Route::get('deleted', 'deleted');
        Route::get('restore/{id}', 'restore');
        Route::delete('hard-delete/{id}', 'hard_delete');
    });

    // Replies
    Route::prefix('replies')->controller(ReplyController::class)->group(function () {
        Route::get('deleted', 'deleted');
        Route::get('restore/{id}', 'restore');
        Route::delete('hard-delete/{id}', 'hard_delete');
    });

    // Users
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('deleted', 'deleted');
        Route::get('restore/{id}', 'restore');
        Route::delete('hard-delete/{id}', 'hard_delete');
    });

    // Reactions
    Route::prefix('reactions')->controller(ReactionController::class)->group(function () {
        Route::get('deleted', 'deleted');
        Route::get('restore/{id}', 'restore');
        Route::delete('hard-delete/{id}', 'hard_delete');
    });

    // Post-Statuses
    Route::prefix('post-statuses')->controller(PostStatusController::class)->group(function () {
        Route::get('deleted', 'deleted');
        Route::get('restore/{id}', 'restore');
        Route::delete('hard-delete/{id}', 'hard_delete');
    });

    // Reaction-Types
    Route::prefix('reaction-types')->controller(ReactionTypeController::class)->group(function () {
        Route::get('deleted', 'deleted');
        Route::get('restore/{id}', 'restore');
        Route::delete('hard-delete/{id}', 'hard_delete');
    });

    // Posts, comments, reactions, users, replies
    Route::apiResources(
        [
            'post-statuses' => PostStatusController::class,
            'posts' => PostController::class,
            'comments' => CommentController::class,
            'reaction-types' => ReactionTypeController::class,
            'replies' => ReplyController::class,
            'users' => UserController::class,
            'reactions' => ReactionController::class,
        ]
    );

    // Auth
    Route::prefix('auth')->controller(AuthController::class)->group(function () {

        // All Sessions
        Route::prefix('sessions')->group(function () {
            Route::get('active', 'active_sessions');
            Route::get('current', 'current_session');
            Route::get('others', 'other_sessions');
            Route::get('{id}', 'show_session');
        });

        // logout
        Route::prefix('logout')->group(function () {
            Route::post('all', 'logout_all');
            Route::post('current', 'logout_current');
            Route::post('others', 'logout_others');
            Route::post('{id}', 'logout_session');
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