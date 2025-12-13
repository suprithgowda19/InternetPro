<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\InstallationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CorporationController;
use App\Http\Controllers\CorporationUserController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\ConstituencyController;
use App\Http\Controllers\Api\ClinicSubmissionController;


Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

//
Route::middleware(['auth', 'active.user',])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('users', UserController::class);

        Route::post(
            '/users/update-status',
            [UserController::class, 'updateStatus']
        )->name('users.updateStatus');
    });

Route::middleware('auth', 'active.user')->group(function () {
    Route::resource('tickets', TicketController::class);
    Route::resource('installations', InstallationController::class);
    Route::get('/installations/{id}/pdf', [InstallationController::class, 'pdf'])
        ->name('installations.pdf');
    Route::get('/users/{id}/pdf', [UserController::class, 'downloadPdf'])
        ->name('users.pdf');
});
Route::middleware(['auth','active.user'])->group(function () {

    Route::resource('corporations', CorporationController::class)
        ->except(['destroy']);

    Route::resource('zones', ZoneController::class)
        ->except(['destroy']);

    Route::resource('constituencies', ConstituencyController::class)
        ->except(['destroy']);

    Route::resource('wards', WardController::class)
        ->except(['destroy']);


});
Route::middleware('auth', 'role:admin')->get('complaints/', [ClinicSubmissionController::class, 'index'])->name('complaints.index');
Route::middleware(['auth', 'role:admin'])
    ->get('/complaints/{complaint}', [ClinicSubmissionController::class, 'show'])
    ->name('complaints.show');
