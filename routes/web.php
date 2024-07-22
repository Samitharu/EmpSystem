<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\logingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('loging');
});

Route::post('/loging', [logingController::class, 'loging']);

Route::middleware(['is.logged'])->group(function () {
    // Routes accessible to admin and HR manager roles
    Route::middleware(['role:admin,HR manager'])->group(function () {
        Route::get('/employee', function () {
            return view('employee');
        });

        Route::post('/saveEmployee', [EmployeeController::class, 'saveEmployee']);
        Route::get('/loadDepartment', [EmployeeController::class, 'loadDepartment']);
        Route::get('/loadEmployees', [EmployeeController::class, 'loadEmployees']);
        Route::get('/getEmployee', [EmployeeController::class, 'getEmployee']);
        Route::put('/updateEmployee/{id}', [EmployeeController::class, 'updateEmployee']);
        Route::delete('/deleteEmployee/{id}', [EmployeeController::class, 'deleteEmployee']);
    });

    // Routes accessible to all roles
    Route::middleware(['role:employee,admin,HR manager'])->group(function () {
        Route::get('/home', function () {
            return view('homePage');
        });

        Route::get('/logout', [logingController::class, 'logout']);
    });

    // Specific routes accessible only by employees
    Route::middleware(['role:employee'])->group(function () {
        Route::get('/settings', function () {
            return view('settings');
        });
    });
});
