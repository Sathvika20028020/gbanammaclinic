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
use App\Http\Controllers\PhcController;


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
        Route::get(
    '/installations/{id}/declaration-pdf',
    [InstallationController::class, 'downloadDeclarationPdf']
)->name('installations.declaration.pdf');
    Route::get('/users/{id}/pdf', [UserController::class, 'downloadPdf'])
        ->name('users.pdf');
});
 Route::get('/complaints/export/pdf', 
        [ClinicSubmissionController::class, 'exportPdf']
    )->name('complaints.export.pdf');

Route::middleware(['auth', 'active.user', 'role:admin'])->group(function () {

    Route::resource('corporations', CorporationController::class)
        ->except(['destroy']);

    Route::resource('zones', ZoneController::class)
        ->except(['destroy']);

    Route::resource('constituencies', ConstituencyController::class)
        ->except(['destroy']);

    Route::resource('wards', WardController::class)
        ->except(['destroy']);

    Route::resource('phcs', PhcController::class);
});
Route::middleware('auth', 'role:admin')->get('complaints/', [ClinicSubmissionController::class, 'index'])->name('complaints.index');
Route::middleware(['auth', 'role:admin'])
    ->get('/complaints/{complaint}', [ClinicSubmissionController::class, 'show'])
    ->name('complaints.show');
    
Route::get('/env-check', function () {
    return [
        'db' => env('DB_DATABASE'),
        'user' => env('DB_USERNAME'),
        'host' => env('DB_HOST'),
    ];
});

Route::get('/internetdata', function () {
    return view('internetdata.index');
})->name('internetdata');

Route::post('/internetdata', function () {
    return redirect()->route('internetdata');
});

Route::get('/internetdata/edit', function () {
    return view('internetdata.edit');
})->name('internetdata.edit');
Route::get('/internetdata/show', function () {
    return view('internetdata.show');
})->name('internetdata.show');
Route::get('/internetdata/create', function () {
    return view('internetdata.create');
})->name('internetdata.create');

Route::get('/members-called', function () {
    return view('members_called.index');
})->name('members_called.index');

Route::post('/members-called', function () {
    return redirect()->route('members_called.index');
});

Route::get('/members-called/create', function () {
    return view('members_called.create');
})->name('members_called.create');

Route::get('/members-called/edit', function () {
    return view('members_called.edit');
})->name('members_called.edit');

Route::get('/members-called/show', function () {
    return view('members_called.show');
})->name('members_called.show');


