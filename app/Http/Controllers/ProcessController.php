<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessRequest;
use App\Models\Process;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Process::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex justify-content-center">
                    <a type="button" data-toggle="modal" data-target="#updateProcess"  onclick="getModelValue(' . $data->id . ')"><button type="button" name="edit"  class="edit  btn-sm" ><i class="fa-solid fa-pen mr-3 editicons" aria-hidden="true"></i></button></a>';
                    $button .= '<a onclick="commonDelete(\'' . route('process.destroy', $data->id) . '\')">
                                <i class="fa fa-trash" style="color: red"></i></i>
                             </a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.process');
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
    public function store(ProcessRequest $request)
    {
        $input = $request->all();
        $storeProcess = Process::create($input);
//        return redirect()->route("process.index")->with("success", "Process Created Successfully.");
        return response(['message' => $storeProcess ? 'Success' : 'fail']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Process $process
     * @return \Illuminate\Http\Response
     */
    public function show(Process $process)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Process $process
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editProcess = Process::findOrFail($id);
        return response(["editModel" => $editProcess]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Process $process
     * @return \Illuminate\Http\Response
     */
    public function update(ProcessRequest $request)
    {
        $updateProcess = Process::findOrFail($request->id);
        $input = $request->all();
        $updateProcess->update($input);
//        return redirect()->route("process.index")->with("success", "Process Updated Successfully.");
        return response(['message' => $updateProcess ? 'Success' : 'fail']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Process $process
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Process::find($request->id)->delete();
            return response(['status' => 'warning', 'message' => 'Process Deleted Successfully!']);
        } catch (\Exception $exception) {
            info('Error::Place@ProcessController@delete - ' . $exception->getMessage());
            return response(['message' => 'Something went wrong!']);
        }
    }
}
