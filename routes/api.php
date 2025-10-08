<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostStatusController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ReactionTypeController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Welcome  API';
});

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('web-login', 'web_login')->middleware('tokenType:web');
    Route::post('mobile-login', 'mobile_login')->middleware('tokenType:mobile');
    Route::post('register', 'register');
});

Route::middleware(['auth:sanctum'])->group(function () {

    // Posts
    Route::prefix('posts')->controller(PostController::class)->group(function () {
        Route::get('deleted', 'deleted')->middleware(['hasRoles:admin,manager']);
        Route::get('restore/{id}', 'restore')->middleware(['hasRoles:admin']);
        Route::delete('force-delete/{id}', 'force_delete')->middleware(['hasRoles:admin', 'isActive']);
    });

    // Comments
    Route::prefix('comments')->controller(CommentController::class)->middleware(['isActive', 'verifiedEmail'])->group(function () {
        Route::get('deleted', 'deleted')->middleware('hasRoles:admin,manager');
        Route::get('restore/{id}', 'restore')->middleware('hasRoles:admin');
        Route::delete('force-delete/{id}', 'force_delete')->middleware('hasRoles:admin');
    });

    // Replies
    Route::prefix('replies')->controller(ReplyController::class)->middleware(['isActive', 'verifiedEmail'])->group(function () {
        Route::get('deleted', 'deleted')->middleware('hasRoles:admin,manager');
        Route::get('restore/{id}', 'restore')->middleware('hasRoles:admin');
        Route::delete('force-delete/{id}', 'force_delete')->middleware('hasRoles:admin');
    });

    // Reactions
    Route::prefix('reactions')->controller(ReactionController::class)->middleware(['isActive', 'verifiedEmail'])->group(function () {
        Route::get('deleted', 'deleted')->middleware('hasRoles:admin,manager');
        Route::get('restore/{id}', 'restore')->middleware('hasRoles:admin');
        Route::delete('force-delete/{id}', 'force_delete')->middleware('hasRoles:admin');
    });

    // Post-Statuses
    Route::prefix('post-statuses')->controller(PostStatusController::class)->middleware(['isActive', 'verifiedEmail'])->group(function () {
        Route::get('deleted', 'deleted')->middleware('hasRoles:admin,manager');
        Route::get('restore/{id}', 'restore')->middleware('hasRoles:admin');
        Route::delete('force-delete/{id}', 'force_delete')->middleware('hasRoles:admin');
    });

    // Reaction-Types
    Route::prefix('reaction-types')->controller(ReactionTypeController::class)->middleware(['isActive', 'verifiedEmail'])->group(function () {
        Route::get('deleted', 'deleted')->middleware('hasRoles:admin,manager');
        Route::get('restore/{id}', 'restore')->middleware('hasRoles:admin');
        Route::delete('force-delete/{id}', 'force_delete')->middleware('hasRoles:admin');
    });

    // Users
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('deleted', 'deleted')->middleware('hasRoles:admin');
        Route::get('restore/{id}', 'restore')->middleware('hasRoles:admin');
        Route::delete('force-delete/{id}', 'force_delete')->middleware(['hasRoles:admin', 'isActive']);
    });

    // Dashboard
    // Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
    //     Route::get('deleted', 'deleted');
    //     Route::get('restore/{id}', 'restore');
    //     Route::delete('force-delete/{id}', 'force_delete');
    // });

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
    Route::prefix('auth')->controller(AuthController::class)->middleware(['isActive', 'verifiedEmail'])->group(function () {

        // All Sessions
        Route::prefix('sessions')->group(function () {
            Route::get('active', 'active_sessions');
            Route::get('current', 'current_session');
            Route::get('others', 'other_sessions');
            Route::get('{id}', 'show_session')->middleware('hasRoles:admin,manager');
        });

        // logout
        Route::prefix('logout')->group(function () {
            Route::post('all', 'logout_all');
            Route::post('current', 'logout_current');
            Route::post('others', 'logout_others');
            Route::get('{id}', 'logout_session')->middleware('hasRoles:admin,manager');
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
