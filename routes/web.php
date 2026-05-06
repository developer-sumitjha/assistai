<?php

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User / PWA Routes
Route::prefix('app')->name('user.')->group(function () {
    Route::get('/', [\App\Http\Controllers\User\UserAuthController::class, 'showOnboarding'])->name('onboarding');
    Route::get('/login', [\App\Http\Controllers\User\UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\User\UserAuthController::class, 'login']);
    Route::post('/logout', [\App\Http\Controllers\User\UserAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('pwa.dashboard');
        })->name('dashboard');

        Route::get('/profile', [\App\Http\Controllers\User\UserProfileController::class, 'show'])->name('profile');
        Route::patch('/profile', [\App\Http\Controllers\User\UserProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/password', [\App\Http\Controllers\User\UserProfileController::class, 'updatePassword'])->name('profile.password');

        // Chat Feature
        Route::get('/chat', [\App\Http\Controllers\User\ChatController::class, 'history'])->name('chat');
        Route::get('/chat/new', [\App\Http\Controllers\User\ChatController::class, 'startNew'])->name('chat.new');
        Route::get('/chat/{conversation}', [\App\Http\Controllers\User\ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{conversation}/send', [\App\Http\Controllers\User\ChatController::class, 'sendMessage'])->name('chat.send');
        Route::post('/chat/{conversation}/clear', [\App\Http\Controllers\User\ChatController::class, 'clearChat'])->name('chat.clear');
        Route::post('/chat/{conversation}/model', [\App\Http\Controllers\User\ChatController::class, 'updateModel'])->name('chat.model');
        // Image Generation Feature
        Route::get('/image', [\App\Http\Controllers\User\ImageController::class, 'index'])->name('image');
        Route::post('/image/generate', [\App\Http\Controllers\User\ImageController::class, 'generate'])->name('image.generate');
        
        // Image to Image Feature
        Route::get('/image-to-image', [\App\Http\Controllers\User\ImageController::class, 'imageToImage'])->name('image_to_image');
        Route::post('/image-to-image/generate', [\App\Http\Controllers\User\ImageController::class, 'generateFromImage'])->name('image_to_image.generate');
    });
});

// Admin Dashboard Protected Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Placeholder for other admin routes mentioned in the layout
    Route::get('/users', function () {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    })->name('users');

    Route::post('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('users.store');

    Route::post('/users/{user}/credits', [\App\Http\Controllers\Admin\AdminCreditController::class, 'manage'])->name('users.credits');
    Route::post('/users/{user}/password', [\App\Http\Controllers\Admin\AdminUserController::class, 'updatePassword'])->name('users.password');

    Route::get('/settings', function () {
        return view('admin.profile');
    })->name('settings');

    // AI Model Management
    Route::get('/models', [\App\Http\Controllers\Admin\AdminAiModelController::class, 'index'])->name('models');
    Route::post('/models', [\App\Http\Controllers\Admin\AdminAiModelController::class, 'update'])->name('models.update');
});
