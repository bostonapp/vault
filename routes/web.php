<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserDocumentController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/public/documents', [HomeController::class, 'publicDocument'])->name('public.document');
Route::get('/public/documents/details/{id}', [HomeController::class, 'publicDocumentDetail'])->name('public.document.detail');



Route::group(['middleware' => ['auth', 'verified', 'role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    Route::get('/dashboard', [DocumentationController::class, 'dashboard'] )->name('dashboard');

    Route::resource('/category', CategoryController::class);

    Route::resource('/documents', DocumentationController::class);
    Route::get('/all/documents', [DocumentationController::class, 'allDocument'])->name('all.document');
    Route::get('/all/documents/show/{id}', [DocumentationController::class, 'publicDocumentShow'])->name('public.document.show');
    Route::get('/all/documents/edit/{id}', [DocumentationController::class, 'publicDocumentEdit'])->name('public.document.edit');
    Route::put('/all/documents/update/{id}', [DocumentationController::class, 'publicDocumentUpdate'])->name('public.document.update');


    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('password.update');

});


Route::group(['middleware' => ['auth', 'verified', 'role:user'], 'prefix' => 'user', 'as' => 'user.'], function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard.dashboard');
    })->name('dashboard');

    Route::resource('/category', UserCategoryController::class);

    Route::get('/dashboard', [UserDocumentController::class, 'dashboard'] )->name('dashboard');
    Route::resource('/documents', UserDocumentController::class);
    Route::get('/all/documents', [UserDocumentController::class, 'allDocument'])->name('all.document');

    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [UserProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/update/password', [UserProfileController::class, 'updatePassword'])->name('password.update');

});


require __DIR__ . '/auth.php';
