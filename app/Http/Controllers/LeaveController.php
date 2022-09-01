<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRejectRequest;
use App\Http\Requests\LeaveRequest;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Auth::user();
            if ($user->can('Leave Approval')) {
                $data = Leave::with('userDetail')->orderByDesc('created_at')->get();
            } else {
                $data = Leave::with('userDetail')->whereUserId($user->id)->orderByDesc('created_at')->get();
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function ($data) {
                    return $data->userDetail->name ?? '-';
                })
                ->editColumn('leave_type', function ($data) {
                    return snakeCaseToTitleCase($data->leave_type) ?? '-';
                })
                ->editColumn('duration', function ($data) {
                    return snakeCaseToTitleCase($data->duration) ?? '-';
                })
                ->addColumn('view', function ($data) use ($user) {
                    $button = '<a href="' . route('leave.show', $data->id) . '"><i class="fa fa-eye text-success"></i></a>';

                    return $button;
                })
                ->addColumn('delete', function ($data) use ($user) {
                    $button = '';
                    if ($data->status == 'Pending') {
                        if ($data->user_id == $user->id) {
                            $button .= '<a onclick="commonDelete(\'' . route('leave.destroy', $data->id) . '\')">
                                <i class="fa fa-trash" style="color: red"></i></i>
                             </a>';
                        } else {
                            $button .= '-';
                        }
                    } else {
                        $button .= '-';
                    }
                    $button .= '';

                    return $button;
                })
                ->addColumn('approval', function ($data) use ($user) {
                    $button = '<div class="d-flex">';
                    if ($data->status == 'Pending') {
                        if ($user->can('Leave Approval')) {

                            $day = (int)now()->format('d');
                            $thisYear = now()->format('Y');

                            if ($day >= 26) {
                                $endDate = Carbon::createFromDate($thisYear, now()->addMonth()->format('m'), 25);
                            } else {
                                $endDate = Carbon::createFromDate($thisYear, now()->format('m'), 25);
                            }

                            if (Carbon::parse($data->start_date) <= $endDate) {
                                $button = '<a onclick="commonApprove(\'' . route('leave.approve', $data->id) . '\')">
                                <i class="fa fa-check text-success mr-3 fa-lg"></i></i></a>';
                            }

                            $button .= '<a onclick="rejectModel(' . $data->id . ')">
                               <i class="fa fa-close text-danger fa-lg"></i></a>';
                        }
                    } else {
                        $button .= '-';
                    }

                    $button .= '</div>';

                    return $button;
                })
                ->rawColumns(['view', 'delete', 'approval'])
                ->make(true);
        }

        return view('leave.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $users = User::where('email', '<>', 'admin@gmail.com')->get();

        $auth = auth()->user();
//        TODO::Need to change Acidus Admin email...
        if ($auth->can('Leave Approval')) {
            $employeeLeaveCount = '';
        } else {
            $employeeLeaveCount = User::select('cl', 'sl', 'pl')->find($auth->id);
        }

        $editLeave = "";
        return view('leave.create', compact('editLeave', 'users', 'employeeLeaveCount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(LeaveRequest $request)
    {
        DB::beginTransaction();
        try {

            Leave::create($request->except('_token'));

            //Send Mail to Team
            $userData = User::find($request['user_id']);

            if ($userData->team_id != null) {
                $termData = Team::find($userData->team_id);
                info($termData);
                if ($termData) {
                    $startDate = Carbon::parse($request['start_date'])->format('d-m-Y');
                    $endDate = Carbon::parse($request['end_date'])->format('d-m-Y');

                    if ($request['leave_type'] == 'casual_leave')
                        $request['leave_type'] = 'Casual Leave';
                    else if ($request['leave_type'] == 'sick_leave')
                        $request['leave_type'] = 'Sick Leave';
                    else
                        $request['leave_type'] = 'Paid Leave';

                    if ($request['duration'] == 'full_day')
                        $request['duration'] = 'Full Day';

                    foreach ($termData->responsible_person as $responsiblePerson) {
                        $responseUser = User::find($responsiblePerson);
                        if ($responseUser) {
                            $data = array('name' => $responseUser->name, 'fromName' => $userData->name, 'startDate' => $startDate, 'endDate' => $endDate, 'Leavetype' => $request['leave_type'], 'duration' => $request['duration'], 'no_of_days' => $request['no_of_days'], 'reason' => $request['reason'], 'team' => $termData->team_name);
                            Mail::send('leave.send-leave-mail', $data, function ($message) use ($responseUser) {
                                $message->to($responseUser->email, $responseUser->name)
                                    ->subject('Leave Applied - Notification');
                            });
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->route("leave.index")->with("success", "Leave Request Submitted Successfully.");

        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@LeaveController@store - ' . $exception->getMessage());
            return redirect()->route("leave.index")->with("warning", "Leave Request Submission Failed.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\leave $leave
     * @return Response
     */
    public function show(leave $leave)
    {
        $viewLeave = Leave::with('userDetail')->find($leave->id);
        return view('leave.show', compact('viewLeave'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\leave $leave
     * @return Response
     */
    public function edit(leave $leave)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\leave $leave
     * @return Response
     */
    public function update(LeaveRequest $request, leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\leave $leave
     * @return Response
     */
    public function destroy(leave $leave)
    {
        DB::beginTransaction();
        try {
            $leave->delete();
            DB::commit();
            return response(['status' => 'success']);

        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@LeaveController@destroy - ' . $exception->getMessage());
            return response(['status' => 'fail']);
        }
    }

    public function leaveApprove(Leave $leave)
    {
        DB::beginTransaction();
        try {
            $user = User::with('team')->find($leave->user_id);

            $balanceDays = $leave->no_of_days;
            $leaveType = $leave->leave_type;
            $availableCL = $user->cl ?? 0;
            $availableSL = $user->sl ?? 0;
            $availablePL = $user->pl ?? 0;
            $takenCL = 0;
            $takenSL = 0;
            $takenPL = 0;

            if (($availableCL + $availableSL + $availablePL) > 0) {
                if ($leaveType == 'casual_leave') {
                    $clBeforeCalculation = $availableCL;
                    list($availableCL, $balanceDays) = $this->leaveCalculation($availableCL, $balanceDays);
                    $takenCL = $clBeforeCalculation - $availableCL;

                    if ($balanceDays != 0) {
                        $slBeforeCalculation = $availableSL;
                        list($availableSL, $balanceDays) = $this->leaveCalculation($availableSL, $balanceDays);
                        $takenSL = $slBeforeCalculation - $availableSL;
                    }

                    if ($balanceDays != 0) {
                        $plBeforeCalculation = $availablePL;
                        list($availablePL, $balanceDays) = $this->leaveCalculation($availablePL, $balanceDays);
                        $takenPL = $plBeforeCalculation - $availablePL;
                    }
                } else if ($leaveType == 'sick_leave') {
                    $slBeforeCalculation = $availableSL;
                    list($availableSL, $balanceDays) = $this->leaveCalculation($availableSL, $balanceDays);
                    $takenSL = $slBeforeCalculation - $availableSL;

                    if ($balanceDays != 0) {
                        $clBeforeCalculation = $availableCL;
                        list($availableCL, $balanceDays) = $this->leaveCalculation($availableCL, $balanceDays);
                        $takenCL = $clBeforeCalculation - $availableCL;
                    }

                    if ($balanceDays != 0) {
                        $plBeforeCalculation = $availablePL;
                        list($availablePL, $balanceDays) = $this->leaveCalculation($availablePL, $balanceDays);
                        $takenPL = $plBeforeCalculation - $availablePL;
                    }
                } else if ($leaveType == 'paid_leave') {
                    $plBeforeCalculation = $availablePL;
                    list($availablePL, $balanceDays) = $this->leaveCalculation($availablePL, $balanceDays);
                    $takenPL = $plBeforeCalculation - $availablePL;

                    if ($balanceDays != 0) {
                        $clBeforeCalculation = $availableCL;
                        list($availableCL, $balanceDays) = $this->leaveCalculation($availableCL, $balanceDays);
                        $takenCL = $clBeforeCalculation - $availableCL;
                    }

                    if ($balanceDays != 0) {
                        $slBeforeCalculation = $availableSL;
                        list($availableSL, $balanceDays) = $this->leaveCalculation($availableSL, $balanceDays);
                        $takenSL = $slBeforeCalculation - $availableSL;
                    }
                }
            }

            $userInput['cl'] = $availableCL;
            $userInput['sl'] = $availableSL;
            $userInput['pl'] = $availablePL;

            $user->update($userInput);

            $leaveInput['status'] = 'Approved';
            $leaveInput['cl_count'] = $takenCL;
            $leaveInput['sl_count'] = $takenSL;
            $leaveInput['pl_count'] = $takenPL;
            $leaveInput['loss_of_pay_count'] = $balanceDays;

            $leave->update($leaveInput);
            DB::commit();

            $data = $this->mailDataGenerate($user, $leave, null);

            Mail::send('leave.approve-leave-mail', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Leave Applied - Notification');
            });

            return response(['status' => 'success', 'message' => 'Leave Request Approved Successfully.']);

        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@LeaveController@leaveApprove - ' . $exception->getMessage());
            return response(['status' => 'fail', 'message' => 'Leave Request Approval Failed, Try Again.']);
        }
    }

    public function leaveCalculation($available, $balance)
    {
        if ($available >= $balance) {
            $available = $available - $balance;
            $balance = 0;
        } else {
            $balance = $balance - $available;
            $available = 0;
        }
        return [$available, $balance];
    }

    public function leaveReject(LeaveRejectRequest $request, Leave $leave)
    {
        DB::beginTransaction();
        try {
            $user = User::with('team')->find($leave->user_id);
            $leave->update(['status' => 'Rejected', 'reject_reason' => $request->reject_reason]);

            DB::commit();

            $data = $this->mailDataGenerate($user, $leave, $request->reject_reason);
            Mail::send('leave.reject-leave-mail', $data, function ($message) use ($user) {
                $message->to($user->email, $user->name)
                    ->subject('Leave Applied - Notification');
            });


            return response(['status' => 'success']);

        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@LeaveController@leaveReject - ' . $exception->getMessage());
            return response(['status' => 'fail']);
        }
    }

    public function getLeaveCount($id)
    {
        $leaveCount = User::select('cl', 'sl', 'pl')->find($id);

        if ($leaveCount) {
            return response(['status' => 'success', 'leaveCount' => $leaveCount]);
        } else {
            return response(['status' => 'fail']);
        }

    }

    public function mailDataGenerate($user, $leave, $leaveRejectReason)
    {
        $startDate = Carbon::parse($leave->start_date)->format('d-m-Y');
        $endDate = Carbon::parse($leave->end_date)->format('d-m-Y');

        if ($leave->leave_type == 'casual_leave')
            $leave->leave_type = 'Casual Leave';
        else if ($leave->leave_type == 'sick_leave')
            $leave->leave_type = 'Sick Leave';
        else
            $leave->leave_type = 'Paid Leave';

        if ($leave->duration == 'full_day')
            $leave->duration = 'Full Day';

        $data = array('name' => $user->name, 'startDate' => $startDate, 'endDate' => $endDate, 'Leavetype' => $leave->leave_type, 'duration' => $leave->duration, 'no_of_days' => $leave->no_of_days, 'reason' => $leave->reason, 'team' => $user->team->team_name, 'reject_reason' => $leaveRejectReason);

        return $data;
    }
}
