<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Bank;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Designation;
use App\Models\Process;
use App\Models\SalaryPercentage;
use App\Models\Shift;
use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesImport;

use App\Exports\EmployeesExport;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = User::with('designation', 'client', 'team', 'shift', 'process')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($data) {
                    return $data->name ?? '-';
                })->editColumn('gender', function ($data) {
                    return $data->gender ?? '-';
                })->editColumn('employee_id', function ($data) {
                    return $data->employee_id ?? '-';
                })->editColumn('salary', function ($data) {
                    return $data->salary ?? '-';
                })->editColumn('designation_name', function ($data) {
                    return $data->designation ? $data->designation->designation_name : '-';
                })->editColumn('shift_name', function ($data) {
                    return $data->shift ? $data->shift->shift_name : '-';
                })->editColumn('team_name', function ($data) {
                    return $data->team ? $data->team->team_name : '-';
                })->editColumn('phone_number', function ($data) {
                    return $data->phone_number ?? '-';
                })->editColumn('email', function ($data) {
                    return $data->email ?? '-';
                })->addColumn('action', function ($data) {
                    $user = Auth::user();
                    $button = '<div class="d-flex justify-content-center">';
                    if ($user->can('View Employee')) {
                        $button .= '<a href = "' . route('employee.show', $data->id) . '" ><button type = "button" name = "view"  id = "' . $data->id . '" class="view  btn-sm" ><i class="fa fa-eye mr-3" aria-hidden = "true" ></i ></button ></a>';
                    }

                    if ($user->can('Edit Employee')) {
                        $button .= '<a href = "' . route('employee.edit', $data->id) . '" ><button type = "button" name = "edit"  id = "' . $data->id . '" class="edit  btn-sm" ><i class="fa-solid fa-pen mr-3 editicons" ></i ></button ></a > ';
                    }

                    if ($user->can('Delete Employee')) {
                        $button .= '<a onclick = "commonDelete(\'' . route('employee.destroy', $data->id) . '\')" ><i class="fa fa-trash" style="color: red"></i></i></a>';
                    }

                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $shifts = Shift::all();
        $designations = Designation::all();
        $teams = Team::all();
        $clients = Client::all();
        $process = Process::all();
        $roles = Role::all();
        $branches = Branch::all();
        $banks = Bank::all();
        $user = '';
        $percentage = SalaryPercentage::first();

        if (!$percentage) {
            return redirect()->route("salary-percentage.show")->with("warning", "Please Update Salary Percentage Details.");
        }

        return view('Employee.create', compact('shifts', 'designations', 'teams', 'banks', 'clients', 'process', 'user', 'roles', 'percentage','branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EmployeeRequest $request)
    {
        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);

            $user->syncRoles($input['assignRole']);

            return redirect()->route("Employee.index")->with("success", "Employee Created Successfully.");
        } catch (\Exception $exception) {
            info('Error::Place@EmployeeController@store - ' . $exception->getMessage());
            return redirect()->back()->with("warning", "Something went wrong" . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::with('designation', 'client', 'team', 'shift', 'process', 'roles','branch', 'bank')->findOrFail($id);
        $user['role'] = collect($user->roles)->first();

        return view('Employee.show', compact('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function profile($id)
    {
        $user = User::with('designation', 'client', 'team', 'shift', 'process', 'branch', 'bank')->findOrFail($id);

        return view('Employee.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $shifts = Shift::all();
        $designations = Designation::all();
        $teams = Team::all();
        $clients = Client::all();
        $process = Process::all();
        $banks = Bank::all();
        $user = User::with('roles')->find($id);

        $user['role'] = collect($user->roles)->first();
        $roles = Role::all();
        $percentage = SalaryPercentage::first();
        $branches = Branch::all();

        return view('Employee.create', compact('shifts', 'designations', 'teams', 'banks', 'clients', 'process', 'user', 'roles', 'percentage','branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EmployeeRequest $request, $id)
    {
        try {
            $user = User::find($id);
            $input = $request->except('password');
            if ($request->password) {
                $input['password'] = Hash::make($request->password);
            }
            $user->update($input);

            $user->syncRoles($input['assignRole']);

            return redirect()->route("Employee.index")->with("success", "Employee Updated Successfully.");
        } catch (\Exception $exception) {
            info('Error::Place@EmployeeController@update - ' . $exception->getMessage());
            return redirect()->back()->with("warning", "Something went wrong" . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            User::find($id)->delete();
            return response(['status' => 'warning', 'message' => 'Employee Deleted Successfully!']);
        } catch (Exception $exception) {
            info('Place@EmployeeController@destroy - ' . $exception->getMessage());
            return response(['status' => 'warning', 'message' => 'Something went wrong!']);
        }
    }

    /**
     * Import employee data
     * */
    public function importEmployee()
    {
        $percentage = SalaryPercentage::first();

        if (!$percentage) {
            return redirect()->route("salary-percentage.show")->with("warning", "Please Update Salary Percentage Details.");
        }

        return view('Employee.import');
    }


    /**
     * Bulk employees add process
     */
    public function bulkEmployeeStore(Request $request)
    {
        if($request->file('excelFile') == ''){
            return redirect()->route("Employee.index")->with("Warning", "File Missing..");
        }else{
            DB::beginTransaction();
            try {
                Excel::import(new EmployeesImport, $request->file('excelFile'));
                DB::commit();
                return redirect()->route("Employee.index")->with("success", "Files Uploaded successfully...");

            } catch (\Exception $exception) {
                DB::rollBack();
                info('Error::Place@EmployeeController@bulkEmployeeStore - ' . $exception->getMessage());
                return redirect()->route("Employee.index")->with("warning", "Unable to Process this File");
            }
        }
    }
    /**
     * Bulk employee export to excel
     */
     public function exportEmployee(){
         //info("Export to Employee");
         return Excel::download(new EmployeesExport, 'users.xlsx');
     }
}
