<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\IdenticanlModelsController;
use App\Http\Controllers\KvppController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->controller(AuthenticatedSessionController::class)->group(function () {
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
});

Route::middleware('auth', 'auth.session')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('/', [ManufacturerController::class, 'index'])->name('manufacturers.index');

    Route::prefix('manufacturers')->controller(ManufacturerController::class)->name('manufacturers.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');
        Route::get('/trash', 'trash')->name('trash');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{item}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
        Route::post('/export', 'export')->name('export');
    });

    Route::prefix('comments')->controller(CommentController::class)->name('comments.')->group(function () {
        Route::get('/manufacturer/{manufacturer}', 'manufacturer')->name('manufacturer');
        Route::get('/generic/{generic}', 'generic')->name('generic');
        Route::get('/process/{process}', 'process')->name('process');
        Route::get('/kvpp/{kvpp}', 'kvpp')->name('kvpp');

        Route::get('/edit/{item}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{item}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
    });

    Route::prefix('meetings')->controller(MeetingController::class)->name('meetings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');
        Route::get('/trash', 'trash')->name('trash');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{item}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
    });

    Route::prefix('generics')->controller(GenericController::class)->name('generics.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');
        Route::get('/trash', 'trash')->name('trash');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{item}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
        Route::post('/export', 'export')->name('export');
        Route::post('/export-vp', 'exportVp')->name('export-vp');

        Route::post('/get-similar-products', 'getSimilarProducts');  // Used on creating for uniqness
    });

    Route::prefix('processes')->controller(ProcessController::class)->name('processes.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');
        Route::get('/trash', 'trash')->name('trash');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{item}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
        Route::post('/export', 'export')->name('export');

        Route::post('/get-create-form-stage-inputs', 'getCreateFormStageInputs');  // Used while creating on status change
        Route::post('/get-create-form-year-inputs', 'getCreateFormYearInputs');  // Used while creating on status & countries change
        Route::post('/get-edit-form-stage-inputs', 'getEditFormStageInputs');  // Used while editing on status change
    });

    Route::prefix('kvpp')->controller(KvppController::class)->name('kvpp.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');
        Route::get('/trash', 'trash')->name('trash');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{item}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
        Route::post('/restore', 'restore')->name('restore');
        Route::post('/export', 'export')->name('export');

        Route::post('/get-similar-products', 'getSimilarProducts');  // Used on creating for uniqness
    });

    Route::prefix('models')->controller(IdenticanlModelsController::class)->name('identical-models.')->middleware('admin')->group(function () {
        Route::get('/', 'list')->name('list');
        Route::get('/{model}', 'index')->name('index');
        Route::get('/{model}/create', 'create')->name('create');
        Route::get('/{model}/edit/{id}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
    });

    Route::prefix('users')->controller(UserController::class)->name('users.')->middleware('admin')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{item}', 'edit')->name('edit');

        Route::post('/store', 'store')->name('store');
        Route::post('/update/{item}', 'update')->name('update');
        Route::post('/destroy', 'destroy')->name('destroy');
    });

    Route::prefix('settings')->controller(SettingController::class)->name('settings.')->group(function () {
        Route::post('/update/locale', 'updateLocale')->name('update.locale');
        Route::post('/update/full-width', 'updateFullWidth')->name('update.full-width');
        Route::post('/update/manufacturers', 'updateManufacturers')->name('update.manufacturers');
        Route::post('/update/meetings', 'updateMeetings')->name('update.meetings');
        Route::post('/update/generics', 'updateGenerics')->name('update.generics');
        Route::post('/update/processes', 'updateProcesses')->name('update.processes');
        Route::post('/update/kvpp', 'updateKvpp')->name('update.kvpp');
    });

    Route::prefix('profile')->controller(ProfileController::class)->name('profile.')->group(function () {
        Route::get('/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
    });
});

