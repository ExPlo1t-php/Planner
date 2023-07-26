<?php

use App\Http\Controllers\CRUD\DepartmentsController;
use App\Http\Controllers\CRUD\DriversController;
use App\Http\Controllers\CRUD\EmployeesController;
use App\Http\Controllers\CRUD\PositionsController;
use App\Http\Controllers\CRUD\TerminalsController;
use App\Http\Controllers\CRUD\UsersController;
use App\Http\Controllers\CRUD\VehiclesController;
use App\Http\Controllers\CRUD\ProjectsController;
use App\Http\Controllers\CRUD\StationsController;
use App\Http\Controllers\CRUD\TeamsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// CRUD routes----------------------------------------------------------
    // Users 
    Route::group(['prefix'=>'users'],function () {
        Route::get('index', [UsersController::class, 'index'])->name('users.index');
        Route::post('create', [UsersController::class, 'create'])->name('users.create');
        Route::delete('destroy/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::get('edit/{id}', [UsersController::class, 'edit'])->name('users.edit');
        Route::put('update/{id}', [UsersController::class, 'update'])->name('users.update');
    });
    // Vehicles
    Route::group(['prefix'=>'vehicles'],function () {
        Route::get('index', [VehiclesController::class, 'index'])->name('vehicles.index');
        Route::post('create', [VehiclesController::class, 'create'])->name('vehicles.create');
        Route::delete('destroy/{id}', [VehiclesController::class, 'destroy'])->name('vehicles.destroy');
        Route::get('edit/{id}', [VehiclesController::class, 'edit'])->name('vehicles.edit');
        Route::put('update/{id}', [VehiclesController::class, 'update'])->name('vehicles.update');
    });
    // Drivers
    Route::group(['prefix'=>'drivers'],function () {
        Route::get('index', [DriversController::class, 'index'])->name('drivers.index');
        Route::post('create', [DriversController::class, 'create'])->name('drivers.create');
        Route::delete('destroy/{id}', [DriversController::class, 'destroy'])->name('drivers.destroy');
        Route::get('edit/{id}', [DriversController::class, 'edit'])->name('drivers.edit');
        Route::put('update/{id}', [DriversController::class, 'update'])->name('drivers.update');
    });
    // Terminals
    Route::group(['prefix'=>'terminals'],function () {
        Route::get('index', [TerminalsController::class, 'index'])->name('terminals.index');
        Route::post('create', [TerminalsController::class, 'create'])->name('terminals.create');
        Route::delete('destroy/{id}', [TerminalsController::class, 'destroy'])->name('terminals.destroy');
        Route::get('edit/{id}', [TerminalsController::class, 'edit'])->name('terminals.edit');
        Route::put('update/{id}', [TerminalsController::class, 'update'])->name('terminals.update');
    });
    // Projects
    Route::group(['prefix'=>'projects'],function () {
        Route::get('index', [ProjectsController::class, 'index'])->name('projects.index');
        Route::post('create', [ProjectsController::class, 'create'])->name('projects.create');
        Route::delete('destroy/{id}', [ProjectsController::class, 'destroy'])->name('projects.destroy');
        Route::get('edit/{id}', [ProjectsController::class, 'edit'])->name('projects.edit');
        Route::put('update/{id}', [ProjectsController::class, 'update'])->name('projects.update');
    });
    // Positions
    Route::group(['prefix'=>'positions'],function () {
        Route::get('index', [PositionsController::class, 'index'])->name('positions.index');
        Route::post('create', [PositionsController::class, 'create'])->name('positions.create');
        Route::delete('destroy/{id}', [PositionsController::class, 'destroy'])->name('positions.destroy');
        Route::get('edit/{id}', [PositionsController::class, 'edit'])->name('positions.edit');
        Route::put('update/{id}', [PositionsController::class, 'update'])->name('positions.update');
    });
    // Teams
    Route::group(['prefix'=>'teams'],function () {
        Route::get('index', [TeamsController::class, 'index'])->name('teams.index');
        Route::post('create', [TeamsController::class, 'create'])->name('teams.create');
        Route::delete('destroy/{id}', [TeamsController::class, 'destroy'])->name('teams.destroy');
        Route::get('edit/{id}', [TeamsController::class, 'edit'])->name('teams.edit');
        Route::put('update/{id}', [TeamsController::class, 'update'])->name('teams.update');
    });
    // Stations
    Route::group(['prefix'=>'stations'],function () {
        Route::get('index', [StationsController::class, 'index'])->name('stations.index');
        Route::post('create', [StationsController::class, 'create'])->name('stations.create');
        Route::delete('destroy/{id}', [StationsController::class, 'destroy'])->name('stations.destroy');
        Route::get('edit/{id}', [StationsController::class, 'edit'])->name('stations.edit');
        Route::put('update/{id}', [StationsController::class, 'update'])->name('stations.update');
    });
    // Departments
    Route::group(['prefix'=>'departments'],function () {
        Route::get('index', [DepartmentsController::class, 'index'])->name('departments.index');
        Route::post('create', [DepartmentsController::class, 'create'])->name('departments.create');
        Route::delete('destroy/{id}', [DepartmentsController::class, 'destroy'])->name('departments.destroy');
        Route::get('edit/{id}', [DepartmentsController::class, 'edit'])->name('departments.edit');
        Route::put('update/{id}', [DepartmentsController::class, 'update'])->name('departments.update');
    });
    // Employees
    Route::group(['prefix'=>'employees'],function () {
        Route::get('index', [EmployeesController::class, 'index'])->name('employees.index');
        Route::post('create', [EmployeesController::class, 'create'])->name('employees.create');
        Route::delete('destroy/{id}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
        Route::get('edit/{id}', [EmployeesController::class, 'edit'])->name('employees.edit');
        // put method gives validation error concerning photo/employee_number/firstname/lastname
        Route::post('update/{id}', [EmployeesController::class, 'update'])->name('employees.update');
    });
// CRUD routes----------------------------------------------------------
});


require __DIR__.'/auth.php';
