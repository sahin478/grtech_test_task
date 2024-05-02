<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DailyQuotesController;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RestrictAccess; 
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $employees = Employee::count();
    $companies = Company::count();
    return Inertia::render('Dashboard',['employees'=>$employees ,'companies' => $companies]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/unauthorized', function () {
    return Inertia::render('unauthorized');
})->name('unauthorized');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware([RestrictAccess::class])->group(function () {
    Route::resource('companies', CompanyController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('/daily-quotes', [DailyQuotesController::class, 'index'])->name('daily-quotes.index');
    });
    
});


require __DIR__.'/auth.php';
