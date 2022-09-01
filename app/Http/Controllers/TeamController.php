<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Team::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex justify-content-center">
                    <a type="button" data-toggle="modal" data-target="#updateTeam"  onclick="getModelValue(' . $data->id . ')"><button type="button" name="edit"  class="edit btn-sm" ><i class="fa-solid fa-pen mr-3 editicons" aria-hidden="true"></i></button></a>';
                    $button .= '<a onclick="commonDelete(\'' . route('team.destroy', $data->id) . '\')">
                                <i class="fa fa-trash" style="color: red"></i></i>
                             </a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $users = User::all();
        return view('master.team',compact('users'));
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
    public function store(TeamRequest $request)
    {
        $input = $request->all();

        $storeTeam = Team::create($input);
        return response(['message' => $storeTeam ? 'Success' : 'fail']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $editTeam = Team::findOrFail($id);
        return response(["editModel" => $editTeam]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function update(TeamRequest $request)
    {
        $updateTeam = Team::findOrFail($request->id);
        $input = $request->all();
        $updateTeam->update($input);
        return response(['message' => $updateTeam ? 'Success' : 'fail']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Team $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            Team::find($request->id)->delete();
            return response(['status' => 'warning', 'message' => 'Team Deleted Successfully!']);
        } catch (\Exception $exception) {
            info('Error::Place@TeamController@delete - ' . $exception->getMessage());
            return response(['message' => 'Something went wrong!']);
        }
    }
}
