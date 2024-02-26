<?php

use App\Http\Controllers\Admin\ExaminationController;
use App\Http\Controllers\Admin\MedicalRecordController;
use App\Http\Controllers\Admin\OdontogramController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Doctor\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('sign-in', [AuthController::class, 'signIn'])->name('sign-in');
Route::post('sign-out', [AuthController::class, 'signOut'])->name('sign-out');

Route::group(['prefix' => 'dashboard', 'middleware' => ['doctor']], function () {
    Route::get('/', DashboardController::class)->name('doctor.dashboard');

    // Queues
    Route::group(['prefix' => 'queues'], function () {
        Route::get('/', [QueueController::class, 'index'])->name('doctor.queues.index');
        Route::put('{id}/update-examination-status', [QueueController::class, 'updateExaminationStatus'])->name('doctor.queues.update-examination-status');
    });

    // Examinations
    Route::group(['prefix' => 'examinations'], function () {
        Route::get('/', [ExaminationController::class, 'index'])->name('doctor.examinations.index');
        Route::get('{id}/create', [ExaminationController::class, 'create'])->name('doctor.examinations.create');
        Route::post('store', [ExaminationController::class, 'store'])->name('doctor.examinations.store');
        Route::get('{id}/edit', [ExaminationController::class, 'edit'])->name('doctor.examinations.edit');
        Route::put('{id}/update', [ExaminationController::class, 'update'])->name('doctor.examinations.update');
        Route::get('{id}/show', [ExaminationController::class, 'show'])->name('doctor.examinations.show');
    });

    // Odontogram
    Route::group(['prefix' => 'odontogram'], function () {
        Route::get('{examination_id}/create', [OdontogramController::class, 'create'])->name('doctor.odontogram.create');
        Route::get('destroy-diagnose/{id}', [OdontogramController::class, 'destroyDiagnose'])->name('doctor.odontogram.destroy-diagnose');
        Route::get('{examination_id}/show', [OdontogramController::class, 'show'])->name('doctor.odontogram.show');
        Route::post('store-diagnose', [OdontogramController::class, 'storeDiagnose'])->name('doctor.odontogram.store-diagnose');
        Route::get('{tooth_number}/get-by-tooth-number', [OdontogramController::class, 'getByToothNumber'])->name('doctor.odontogram.get-by-tooth-number');
    });

    // Transaction
    Route::group(['prefix' => 'transactions'], function () {
        Route::get('{examination_id}/create', [TransactionController::class, 'create'])->name('doctor.transactions.create');

        // Treatment
        Route::post('add-treatment', [TransactionController::class, 'addTreatment'])->name('doctor.transactions.add-treatment');
        Route::delete('remove-treatment', [TransactionController::class, 'removeTreatment'])->name('doctor.transactions.remove-treatment');

        // Item
        Route::post('add-item', [TransactionController::class, 'addItem'])->name('doctor.transactions.add-item');
        Route::delete('remove-item', [TransactionController::class, 'removeItem'])->name('doctor.transactions.remove-item');

        // Addon
        Route::post('add-addon', [TransactionController::class, 'addAddon'])->name('doctor.transactions.add-addon');
        Route::delete('remove-addon', [TransactionController::class, 'removeAddon'])->name('doctor.transactions.remove-addon');
    });
});

require __DIR__ . '/auth.php';
