<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\SalaryPercentageController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

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
    if(auth()->user()){
        return redirect()->route('home');
    }
    return view('auth.login');
});

Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

//PayRoll
Route::get('payroll', [PayrollController::class, 'index'])->name('payroll.index')->middleware('permission:Generate Payslip|Send Mail|Edit Payslip|View Payslip');
Route::get('payroll/edit/{payroll}', [PayrollController::class, 'edit'])->name('payroll.edit')->middleware('can:Edit Payslip');
Route::put('payroll/update/{payroll}', [PayrollController::class, 'update'])->name('payroll.update')->middleware('can:Edit Payslip');
Route::get('payroll/show/{payroll}', [PayrollController::class, 'show'])->name('payroll.show')->middleware('can:View Payslip');
Route::post('generate-payslip-for-all-employees', [PayrollController::class, 'generatePayslipForAllEmployees'])->name('generatePayslipForAllEmployees')->middleware('can:Generate Payslip');
Route::get('payroll/payslip/email/{month}', [PayrollController::class, 'sendPayrollEmail'])->name('payroll.sendPayrollEmail')->middleware('can:Send Mail');
Route::get('payroll/payslip/generate/pdf/{id}', [PayrollController::class, 'generatePaySlipPdf'])->name('payroll.generatePaySlipPdf')->middleware('can:View Payslip');


Route::group(['middleware' => ['can:Shift']], function () {
//shift
    Route::get('shift', [ShiftController::class, 'index'])->name('shift.index');
    Route::post('shift/store', [ShiftController::class, 'store'])->name('shift.store');
    Route::get('shift/edit/{id}', [ShiftController::class, 'edit'])->name('shift.edit');
    Route::put('shift/update', [ShiftController::class, 'update'])->name('shift.update');
    Route::delete('shift/destroy/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy');
});

Route::group(['middleware' => ['can:Designation']], function () {
//designation
    Route::get('designation', [DesignationController::class, 'index'])->name('designation.index');
    Route::post('designation/store', [DesignationController::class, 'store'])->name('designation.store');
    Route::get('designation/edit/{id}', [DesignationController::class, 'edit'])->name('designation.edit');
    Route::put('designation/update', [DesignationController::class, 'update'])->name('designation.update');
    Route::delete('designation/destroy/{id}', [DesignationController::class, 'destroy'])->name('designation.destroy');
});

Route::group(['middleware' => ['can:Process']], function () {
//Process
    Route::get('process', [ProcessController::class, 'index'])->name('process.index');
    Route::post('process/store', [ProcessController::class, 'store'])->name('process.store');
    Route::get('process/edit/{id}', [ProcessController::class, 'edit'])->name('process.edit');
    Route::put('process/update', [ProcessController::class, 'update'])->name('process.update');
    Route::delete('process/destroy/{id}', [ProcessController::class, 'destroy'])->name('process.destroy');
});

Route::group(['middleware' => ['can:Team']], function () {
//Team
    Route::get('team', [TeamController::class, 'index'])->name('team.index');
    Route::post('team/store', [TeamController::class, 'store'])->name('team.store');
    Route::get('team/edit/{id}', [TeamController::class, 'edit'])->name('team.edit');
    Route::put('team/update', [TeamController::class, 'update'])->name('team.update');
    Route::delete('team/destroy/{id}', [TeamController::class, 'destroy'])->name('team.destroy');
});

Route::group(['middleware' => ['can:Client']], function () {
//client
    Route::get('client', [ClientController::class, 'index'])->name('client.index');
    Route::post('client/store', [ClientController::class, 'store'])->name('client.store');
    Route::get('client/edit/{id}', [ClientController::class, 'edit'])->name('client.edit');
    Route::put('client/update', [ClientController::class, 'update'])->name('client.update');
    Route::delete('client/destroy/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
});

//Employee
Route::get('Employee', [EmployeeController::class, 'index'])->name('Employee.index')->middleware('permission:Create Employee|Edit Employee|View Employee|Delete Employee');
Route::get('Employee/create', [EmployeeController::class, 'create'])->name('Employee.create')->middleware('can:Create Employee');
Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store')->middleware('can:Create Employee');
Route::get('employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware('can:Edit Employee');
Route::get('employee/{id}', [EmployeeController::class, 'show'])->name('employee.show')->middleware('can:View Employee');
Route::get('employee/profile/{id}', [EmployeeController::class, 'profile'])->name('employee.profile');
Route::put('employee/update/{id}', [EmployeeController::class, 'update'])->name('employee.update')->middleware('can:Edit Employee');
Route::delete('employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy')->middleware('can:Delete Employee');


//leave
Route::get('leave', [LeaveController::class, 'index'])->name('leave.index')->middleware('permission:Leave Approval|Leave Apply');
Route::get('leave/create', [LeaveController::class, 'create'])->name('leave.create')->middleware('can:Leave Apply');
Route::get('leave/count/get/ajax/{id}', [LeaveController::class, 'getLeaveCount'])->name('leave.getLeaveCount')->middleware('can:Leave Approval');
Route::post('leave/store', [LeaveController::class, 'store'])->name('leave.store')->middleware('can:Leave Apply');
Route::get('leave/show/{leave}', [LeaveController::class, 'show'])->name('leave.show')->middleware('permission:Leave Approval|Leave Apply');
Route::get('leave/approve/{leave}', [LeaveController::class, 'leaveApprove'])->name('leave.approve')->middleware('can:Leave Approval');
Route::get('leave/reject/{leave}', [LeaveController::class, 'leaveReject'])->name('leave.reject')->middleware('can:Leave Approval');
Route::delete('leave/delete/{leave}', [LeaveController::class, 'destroy'])->name('leave.destroy')->middleware('permission:Leave Approval|Leave Apply');

Route::group(['middleware' => ['can:Salary Percentage']], function () {
//client
    Route::get('salary-percentage/show', [SalaryPercentageController::class, 'show'])->name('salary-percentage.show');
    Route::get('salary-percentage/edit', [SalaryPercentageController::class, 'edit'])->name('salary-percentage.edit');
    Route::put('salary-percentage/update', [SalaryPercentageController::class, 'update'])->name('salary-percentage.update');
});

Route::group(['middleware' => ['can:Roles']], function () {
//role crud
    Route::get('roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
    Route::get('role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::get('role/{id}', [RoleController::class, 'show'])->name('role.show');
    Route::put('role/update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('role/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');
});

Route::delete('/role/delete/{id}', [RoleController::class, 'destroy'])->name('role.destroy');

//employee Import
Route::get('import-employee-excel',[EmployeeController::class,'importEmployee'])->name('import-employee-excel');
Route::post('import-employee/store',[EmployeeController::class,'bulkEmployeeStore'])->name('bulk-employee.store');

//Export Employee

Route::get('export-employee-excel',[EmployeeController::class,'exportEmployee'])->name('Employee.export');
Route::post('exportPayroll', [PayrollController::class, 'exportPayroll'])->name('exportPayroll');

// Branch
Route::group(['middleware' => ['can:Branch']], function () {

    Route::get('branch', [BranchController::class, 'index'])->name('branch.index');
    Route::post('branch/store', [BranchController::class, 'store'])->name('branch.store');
    Route::delete('branch/destroy/{id}', [BranchController::class, 'destroy'])->name('branch.destroy');
    Route::get('branch/edit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
    Route::put('branch/update', [BranchController::class, 'update'])->name('branch.update');

});

// Branch
Route::group(['middleware' => ['can:Bank']], function () {
    Route::get('bank', [BankController::class, 'index'])->name('bank.index');
    Route::post('bank/store', [BankController::class, 'store'])->name('bank.store');
    Route::get('bank/edit/{id}', [BankController::class, 'edit'])->name('bank.edit');
    Route::put('bank/update', [BankController::class, 'update'])->name('bank.update');
    Route::delete('bank/destroy/{id}', [BankController::class, 'destroy'])->name('bank.destroy');
});
