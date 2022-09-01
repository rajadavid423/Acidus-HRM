<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShiftRequest;
use App\Models\Shift;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Shift::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex justify-content-center">
                    <a type="button" data-toggle="modal" data-target="#updateShift"  onclick="getModelValue(' . $data->id . ')">
                    <button type="button" name="edit"  class="edit  btn-sm" ><i class="fa-solid fa-pen mr-3 editicons" aria-hidden="true"></i></button></a>';
                    $button .= '<a onclick="commonDelete(\'' . route('shift.destroy', $data->id) . '\')">
                                <i class="fa fa-trash" style="color: red"></i></i>
                             </a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.shift');
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
    public function store(ShiftRequest $request)
    {
        $input = $request->all();
        $storeShift = Shift::create($input);
//        return redirect()->route("team.index")->with("success", "Team Created Successfully.");
        return response(['message' => $storeShift ? 'Success' : 'fail']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editShift = Shift::findOrFail($id);
        return response(["editModel" => $editShift]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function update(ShiftRequest $request)
    {
        $updateShift = Shift::findOrFail($request->id);
        $input = $request->all();
        $updateShift->update($input);
//        return redirect()->route("process.index")->with("success", "Process Updated Successfully.");
        return response(['message' => $updateShift ? 'Success' : 'fail']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Shift $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Shift::find($request->id)->delete();
            return response(['status' => 'warning', 'message' => 'Shift Deleted Successfully!']);
        } catch (\Exception $exception) {
            info('Error::Place@ShiftController@delete - ' . $exception->getMessage());
            return response(['message' => 'Something went wrong!']);
        }
    }
}
