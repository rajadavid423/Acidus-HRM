<?php

namespace App\Http\Controllers;

use App\Http\Requests\DesignationRequest;
use App\Models\Designation;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\True_;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Designation::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex justify-content-center">
                    <a type="button" data-toggle="modal" data-target="#updateDesignation"  onclick="getModelValue(' . $data->id . ')"><button type="button" name="edit"  class="edit  btn-sm" ><i class="fa-solid fa-pen mr-3 editicons" aria-hidden="true"></i></button></a>';
                    $button .= '<a onclick="commonDelete(\'' . route('designation.destroy', $data->id) . '\')">
                                <i class="fa fa-trash" style="color: red"></i></i>
                             </a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.designation');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignationRequest $request)
    {
        $input = $request->all();
        $storeDesignation = Designation::create($input);
        return response(['message' => $storeDesignation ? 'Success' : 'fail']);
//        return redirect()->route("designation.index")->with("success", "Designation Created Successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Designation $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Designation $designation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editDesignation = Designation::findOrFail($id);
        return response(["editModel" => $editDesignation]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Designation $designation
     * @return \Illuminate\Http\Response
     */
    public function update(DesignationRequest $request)
    {
        $updateDesignation = Designation::findOrFail($request->id);
        $input = $request->all();
        $updateDesignation->update($input);
//        return redirect()->route("designation.index")->with("success", "Designation Updated Successfully.");
        return response(['message' => $updateDesignation ? 'Success' : 'fail']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Designation $designation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Designation::find($request->id)->delete();
            return response(['status' => 'warning', 'message' => 'Designation Deleted Successfully!']);
        } catch (\Exception $exception) {
            info('Error::Place@DesignationController@delete - ' . $exception->getMessage());
            return response(['message' => 'Something went wrong!']);
        }
    }
}
