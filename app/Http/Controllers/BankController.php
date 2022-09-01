<?php

namespace App\Http\Controllers;

use App\Http\Requests\BankRequest;
use App\Models\Bank;
use App\Models\Branch;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bank::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<div class="d-flex justify-content-center">
                    <a type="button" data-toggle="modal" data-target="#updateBranch"  onclick="getModelValue(' . $data->id . ')"><button type="button" name="edit"  class="edit  btn-sm" ><i class="fa-solid fa-pen mr-3 editicons" aria-hidden="true"></i></button></a>';
                    $button .= '<a onclick="commonDelete(\'' . route('bank.destroy', $data->id) . '\')">
                                <i class="fa fa-trash" style="color: red"></i></i>
                             </a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.bank');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(BankRequest $request)
    {
        try {
            $input = $request->all();
            Bank::create($input);
            return response(['message' => 'Success']);
        } catch (Exception $exception) {
            info('Error::Place@BankController@store - ' . $exception->getMessage());
            return response(['message' => 'fail']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        $bank = Bank::findOrFail($id);
        return response(["editModel" => $bank]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BankRequest $request
     * @return Response
     */
    public function update(BankRequest $request)
    {
        try {
            $bank = Bank::findOrFail($request->id);
            $input = $request->all();
            $bank->update($input);
            return response(['message' => 'Success']);
        } catch (Exception $exception) {
            info('Error::Place@BankController@update - ' . $exception->getMessage());
            return response(['message' => 'fail']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Branch  $branch
     * @return Response
     */
    public function destroy($id)
    {
        try {
            Bank::find($id)->delete();
            return response(['status' => 'warning', 'message' => 'Bank Deleted Successfully!']);
        } catch (Exception $exception) {
            info('Error::Place@BankController@delete - ' . $exception->getMessage());
            return response(['message' => 'Something went wrong!']);
        }
    }
}
