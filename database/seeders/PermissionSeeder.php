<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
        public function run()
    {
        $permissions = [
            //Masters
            ['name' => 'Shift', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Designation', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Process', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Team', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Client', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Salary Percentage', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Roles', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Branch', 'guard_name' => 'web', 'model' => 'Masters'],
            ['name' => 'Bank', 'guard_name' => 'web', 'model' => 'Masters'],

            //Employee
            ['name' => 'Create Employee', 'guard_name' => 'web', 'model' => 'Employee'],
            ['name' => 'View Employee', 'guard_name' => 'web', 'model' => 'Employee'],
            ['name' => 'Edit Employee', 'guard_name' => 'web', 'model' => 'Employee'],
            ['name' => 'Delete Employee', 'guard_name' => 'web', 'model' => 'Employee'],
            ['name' => 'Import Employee', 'guard_name' => 'web', 'model' => 'Employee'],

            //Payroll
            ['name' => 'Generate Payslip', 'guard_name' => 'web', 'model' => 'Payroll'],
            ['name' => 'Send Mail', 'guard_name' => 'web', 'model' => 'Payroll'],
            ['name' => 'Edit Payslip', 'guard_name' => 'web', 'model' => 'Payroll'],
            ['name' => 'View Payslip', 'guard_name' => 'web', 'model' => 'Payroll'],
            ['name' => 'Export Payroll', 'guard_name' => 'web', 'model' => 'Payroll'],

            //leave Approval
            ['name' => 'Leave Approval', 'guard_name' => 'web', 'model' => 'Leave'],
            ['name' => 'Leave Apply', 'guard_name' => 'web', 'model' => 'Leave'],

        ];

        foreach ($permissions as $permission) {
            if (!Permission::whereName($permission['name'])->exists()) {
                Permission::create($permission);
            }
        }

        $dbPermission = Permission::all()->pluck('name');
        $collectionPermission = collect($permissions)->pluck('name');

        $differenceArray = array_diff($dbPermission->toArray(), $collectionPermission->toArray());
        Permission::whereIn('name', $differenceArray)->delete();

        $permissionsIds = Permission::all()->pluck('id');

        if (!Role::whereName('Super Admin')->exists()) {
            $role = Role::create(['name' => 'Super Admin']);
            $role->givePermissionTo($permissionsIds);

            $user = [
                "name" => 'Acidus-HRM',
                "employee_id" => 'EM001',
                "email" => 'admin@gmail.com',
                "password" => Hash::make('admin@123'),
            ];

            $user = User::create($user);
            $user->assignRole($role->id);
        } else {
            $role = Role::whereName('Super Admin')->first();
            $role->syncPermissions($permissionsIds);
        }

        if (!Role::whereName('Employee')->exists()) {
            $employeePermissionsIds = Permission::whereIn('name',['Leave Apply', 'View Payslip'])->pluck('id');
            $role = Role::create(['name' => 'Employee']);
            $role->syncPermissions($employeePermissionsIds);
        }
    }
}
