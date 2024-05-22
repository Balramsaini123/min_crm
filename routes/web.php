<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AdminController::class, 'loginblade'])->name('login')->middleware('guest');
Route::post('/login', [AdminController::class, 'login'])->name('login.post');

Route::middleware('auth')->group( function (){

   Route::get('companies/employees_list/{id}', [CompanyController::class, 'showEmployeeList'])->name('companies.showEmployeeList');
   Route::resource('companies', CompanyController::class);
   Route::resource('employees', EmployeeController::class);
   Route::get('/logout', [AdminController::class,'logout'])->name('logout');
   Route::get('/deleted_companies', [CompanyController::class, 'deleted_companies'])->name('deleted_companies');
   Route::get('/restore', [CompanyController::class, 'restore'])->name('restore.company');
   Route::get('/edit_employee/{id}', [CompanyController::class, 'edit_employee'])->name('edit.employee');

});
