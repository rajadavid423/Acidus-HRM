<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use http\Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::all();
            $user = auth()->user();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('view', function ($data) use ($user) {
                    return '<a href="' . route('role.show', $data->id) . '"><i class="fa fa-eye" style="color: green"></i></a>';
                })
                ->addColumn('edit', function ($data) use ($user) {
                                  if ($data->name == 'Super Admin') {
                        return '-';
                    }
                    return '<a href="' . route('role.edit', $data->id) . '"><i class="fa-solid fa-pen mr-3 editicons" ></i></a>';
                })
                ->addColumn('delete', function ($data) use ($user) {
                    if ($data->name == 'Super Admin' || $data->name == 'Employee') {
                        return '-';
                    }
                    return '<a onclick="commonDelete(\'' . route('role.destroy', $data->id) . '\')">
                                <i class="fa fa-trash" style="color: red"></i></i>
                             </a>';
                })
                ->rawColumns(['view', 'edit', 'delete'])
                ->make(true);
        }

        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $role = '';
        $permissions = Permission::all()->groupBy('model');
        return view('role.create', compact('permissions', 'role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create(['name' => $request['name']]);
            $role->givePermissionTo([$request['permissions']]);
            DB::commit();

            return redirect()->route("role.index")->with("success", "Role Created Successfully.");

        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@RoleController@store - ' . $exception->getMessage());
            return redirect()->back()->with("warning", "Something went wrong" . $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all()->groupBy('model');

        return view('role.create', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all()->groupBy('model');

        return view('role.show', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $input = $request->only(['name']);
            $role = Role::find($id);
            $role->update($input);
            $role->syncPermissions($request['permissions']);
            DB::commit();

            return redirect()->route("role.index")->with("success", "Role Updated Successfully.");

        } catch (\Exception $exception) {
            DB::rollBack();
            info('Place@RoleController@update - ' . $exception->getMessage());
            return redirect()->back()->with("warning", "Something went wrong" . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return Application|ResponseFactory|Response
     */
    public function destroy(Request $request)
    {
        try {
            Role::find($request->id)->delete();
            return response(['status' => 'warning', 'message' => 'Role Deleted Successfully!']);
        } catch (\Exception $exception) {
            info('Error::Place@RoleController@delete - ' . $exception->getMessage());
            return response(['message' => 'Something went wrong!']);
        }
    }
}
