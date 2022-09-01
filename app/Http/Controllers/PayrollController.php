<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Exports\PayrollsExport;
use App\Http\Requests\PayrollRequest;
use App\Jobs\EmployeePayslipMailJob;
use App\Models\Leave;
use App\Models\LeaveRecord;
use App\Models\Payroll;
use App\Models\SalaryPercentage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = auth()->user();
            $data = Payroll::with('userDetail')->when($request->monthYear, function ($query) use ($request) {
                $query->whereBetween('month', [Carbon::parse($request->monthYear)->startOfMonth(), Carbon::parse($request->monthYear)->endOfMonth()]);
            })->when(!($user->can('Generate Payslip') || $user->can('Send Mail')), function ($query) {
                $query->whereUserId(auth()->id());
            })->orderBy('id', 'desc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_name', function ($data) {
                    return $data->userDetail ? $data->userDetail->name : '-';
                })->editColumn('month_year', function ($data) {
                    return $data->month ? Carbon::parse($data->month)->format('M-Y') : '-';
                })->editColumn('gross', function ($data) {
                    return $data->gross ?? '-';
                })->editColumn('net_salary', function ($data) {
                    return $data->net_salary ?? '-';
                })->editColumn('employee_id', function ($data) {
                    return $data->userDetail ? $data->userDetail->employee_id : '-';
                })->addColumn('action', function ($data) use ($user) {
                    $button = '<div class="d-flex justify-content-center">';

                    if ($user->can('View Payslip')) {
                        $button .= '<a href="' . route('payroll.show', $data->id) . '"><i class="fa fa-eye text-success mr-3" aria-hidden="true"></i></a>';
                    }

                    if ($user->can('Edit Payslip')) {
                        $button .= '<a href="' . route('payroll.edit', $data->id) . '"><i class="fa-solid fa-pen mr-3 editicons" aria-hidden="true"></i></a>';
                    }

                    if ($user->can('View Payslip')) {
                        $button .= '<a href="' . route('payroll.generatePaySlipPdf', $data->id) . '"><i class="fa-solid fa-print mr-3 text-info" aria-hidden="true"></i></a>';
                    }

                    $button .= '</div>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('payroll.index');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Payroll $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        $editPayroll = Payroll::with('userDetail', 'userDetail.designation', 'userDetail.team')->findOrFail($payroll->id);

        return view('payroll.show', compact('editPayroll'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Payroll $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        $editPayroll = Payroll::with('userDetail', 'userDetail.designation', 'userDetail.team')->findOrFail($payroll->id);

        return view('payroll.edit', compact('editPayroll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Payroll $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(PayrollRequest $request, Payroll $payroll)
    {
        DB::beginTransaction();
        try {
            $payrollInput = $request->only('special_day_allowance', 'special_allowance', 'shift_allowance', 'other_allowance',
                'total_earnings', 'tds_deduction', 'other_deduction', 'medi_claim', 'total_deduction', 'net_salary', 'comments');

            $payroll->update($payrollInput);
            DB::commit();
            return redirect()->route("payroll.index")->with("success", "Payslip Updated Successfully.");

        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@PayrollController@update - ' . $exception->getMessage());
            return redirect()->back()->with("warning", "Something went wrong" . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Payroll $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
    }

    public function generatePaySlipPdf($id)
    {
        $payroll = Payroll::with('userDetail', 'userDetail.designation', 'userDetail.team')->findOrFail($id);
        $payterm =  Carbon::parse($payroll->month)->format('m-Y');
        $leaveRecord = LeaveRecord::where('user_id',$payroll['user_id'])->where('pay_term',$payterm)->first();

        $image = public_path('images/123.png');
        // Read image path, convert to base64 encoding
        $imageData = base64_encode(file_get_contents($image));

        // Format the image SRC:  data:{mime};base64,{data};
        $logo = 'data:' . mime_content_type($image) . ';base64,' . $imageData;

        $pdf = PDF::loadView('payroll.payslip-pdf', compact('payroll', 'logo','leaveRecord'));

        return $pdf->setPaper('a4', 'portrait')->setWarnings(false)->stream('HRM.pdf');
    }

    public function sendPayrollEmail($month)
    {
        try {
            EmployeePayslipMailJob::dispatch($month);

            return response(['status' => 'success']);
        } catch (\Exception $exception) {
            info('Error::Place@PayrollController@sendPayrollEmail - ' . $exception->getMessage());
            return response(['status' => 'fail']);
        }
    }

    //TODO::Month start from 1 to 30 //
//    public function generatePayslipForAllEmployees(Request $request)
//    {
//        try {
//            $monthYear = $request->monthYear;
//            $percentage = SalaryPercentage::first();
//
//            if (!$percentage) {
//                return response(['status' => 'warning', 'message' => 'Failed! Salary percentage details not found!']);
//            }
//
//            //TODO::Need to update the super admin mail id
//            $eligibleEmployees = User::whereNull('date_of_leaving')
//                ->where('email', '<>', 'admin@gmail.com')->get();
//
//            foreach ($eligibleEmployees as $employee) {
//                $payRollExists = Payroll::whereUserId($employee->id)
//                    ->whereBetween('month', [Carbon::parse($monthYear)->startOfMonth(), Carbon::parse($monthYear)->endOfMonth()])
//                    ->exists();
//
//                if (!$payRollExists && Carbon::parse($monthYear)->endOfMonth() > Carbon::parse($employee->date_of_joining)) {
//                    $payRollInput = [];
//                    $payRollInput['user_id'] = $employee->id;
//                    $payRollInput['month'] = Carbon::parse($monthYear)->endOfMonth();
//                    $salary = $employee->salary;
//                    $payRollInput['gross'] = $salary;
//                    $payRollInput['working_days'] = 30;
//
//                    $lossOfPayCount = Leave::whereUserId($employee->id)
//                        ->whereBetween('start_date', [Carbon::parse($monthYear)->startOfMonth(), Carbon::parse($monthYear)->endOfMonth()])
//                        ->whereBetween('end_date', [Carbon::parse($monthYear)->startOfMonth(), Carbon::parse($monthYear)->endOfMonth()])
//                        ->sum('loss_of_pay_count');
//
//                    if (Carbon::parse($monthYear)->startOfMonth() > Carbon::parse($employee->date_of_joining)) {
//                        $payRollInput['days_present'] = $payRollInput['working_days'] - $lossOfPayCount;
//                    } else {
//                        $joiningDate = Carbon::parse($employee->date_of_joining);
//                        $payRollInput['days_present'] = $joiningDate->diffInDays(Carbon::parse($monthYear)->endOfMonth()) - $lossOfPayCount;
//                    }
//
//                    $fullSalaryPerDay = $salary / $payRollInput['working_days'];
//                    $earnedSalary = $fullSalaryPerDay * $payRollInput['days_present'];
//                    $earnedSalaryPerPercentage = $earnedSalary / 100;
//
//                    $payRollInput['basic'] = $earnedSalaryPerPercentage * $percentage->basic;
//                    $payRollInput['hra'] = $earnedSalaryPerPercentage * $percentage->hra;
//                    $payRollInput['special_day_allowance'] = 0;
//                    $payRollInput['special_allowance'] = 0;
//                    $payRollInput['shift_allowance'] = 0;
//                    $payRollInput['other_allowance'] = 0;
//                    $payRollInput['total_earnings'] = $payRollInput['basic'] + $payRollInput['hra'] + $payRollInput['special_day_allowance'] + $payRollInput['special_allowance'] + $payRollInput['shift_allowance'] + $payRollInput['other_allowance'];
//                    $payRollInput['esi'] = ($salary >= 21000) ? 0 : (($salary / 100) * $percentage->esi);
//                    $payRollInput['epf'] = ($payRollInput['basic'] >= 15000) ? 1800 : (($payRollInput['basic'] / 100) * $percentage->pf);
//                    $payRollInput['tds_deducted'] = 0;
//                    $payRollInput['v_pass'] = 0;
//                    $payRollInput['ins_deducted'] = $employee->insurance;
//                    $payRollInput['total_deduction'] = $payRollInput['esi'] + $payRollInput['epf'] + $payRollInput['tds_deducted'] + $payRollInput['v_pass'] + $payRollInput['ins_deducted'];
//                    $payRollInput['net_salary'] = $payRollInput['total_earnings'] - $payRollInput['total_deduction'];
//                    $payRollInput['bank_name'] = $employee->bank_name;
//                    $payRollInput['account_number'] = $employee->account_number;
//                    $payRollInput['ifsc_code'] = $employee->ifsc;
//                    $payRollInput['comments'] = '';
//
//                    Payroll::create($payRollInput);
//                }
//            }
//
//            return response(['status' => 'success', 'message' => 'PaySlip Generated Successfully!']);
//        } catch (\Exception $exception) {
//            info('Error::Place@PayrollController@generatePayslipForAllEmployees - ' . $exception->getMessage());
//            return response(['status' => 'warning']);
//        }
//    }

//TODO::26-of this month to Next month 25 calculation
    public function generatePayslipForAllEmployees(Request $request)
    {
        try {
            $monthYear = $request->monthYear;

            //Start date
            $startDay = Carbon::parse($monthYear)->subMonth();
            $startDate = Carbon::createFromDate($startDay->year, $startDay->month, 26);

            //End date
            $endDay = Carbon::parse($monthYear);
            $endDate = Carbon::createFromDate($endDay->year, $endDay->month, 25);

            $percentage = SalaryPercentage::first();

            if (!$percentage){
                return response(['status' => 'warning', 'message' => 'Failed! Salary percentage details not found!']);
            }

            //TODO::Need to update the super admin mail id
            $eligibleEmployees = User::with('bank')->whereNull('date_of_leaving')
                ->where('email', '<>', 'admin@gmail.com')->get();

            foreach ($eligibleEmployees as $employee) {
                $payRollExists = Payroll::whereUserId($employee->id)
                    ->whereBetween('month', [Carbon::parse($startDate), Carbon::parse($endDate)])
                    ->exists();

//                if (!$payRollExists && Carbon::parse($monthYear)->endOfMonth() > Carbon::parse($employee->date_of_joining)) {
                if (!$payRollExists && $endDate > Carbon::parse($employee->date_of_joining)) {
                    $payRollInput = [];
                    $payRollInput['user_id'] = $employee->id;
                    $payRollInput['month'] = $endDate; //Carbon::parse($monthYear)->endOfMonth();
                    $salary = $employee->salary;
                    $payRollInput['gross'] = $salary;
                    $payRollInput['working_days'] = 30;

                    $lossOfPayCount = Leave::whereUserId($employee->id)
                        ->whereBetween('start_date', [$startDate, $endDate])
                        ->whereBetween('end_date', [$startDate, $endDate])
                        ->sum('loss_of_pay_count');

//                    if (Carbon::parse($monthYear)->startOfMonth() > Carbon::parse($employee->date_of_joining)) {
                    if ($startDate > Carbon::parse($employee->date_of_joining)) {
                        $payRollInput['days_present'] = $payRollInput['working_days'] - $lossOfPayCount;
                    } else {
                        $joiningDate = Carbon::parse($employee->date_of_joining);
                        $payRollInput['days_present'] = $joiningDate->diffInDays($endDate) - $lossOfPayCount;
                    }

                    $fullSalaryPerDay = $salary / $payRollInput['working_days'];
                    $earnedSalary = $fullSalaryPerDay * $payRollInput['days_present'];
                    $earnedSalaryPerPercentage = $earnedSalary / 100;

                    $payRollInput['basic'] = $earnedSalaryPerPercentage * $percentage->basic;
                    $payRollInput['hra'] = $earnedSalaryPerPercentage * $percentage->hra;
                    $payRollInput['special_day_allowance'] = 0;
                    $payRollInput['special_allowance'] = 0;
                    $payRollInput['shift_allowance'] = 0;
                    $payRollInput['other_allowance'] = 0;
                    $payRollInput['total_earnings'] = $payRollInput['basic'] + $payRollInput['hra'] + $payRollInput['special_day_allowance'] + $payRollInput['special_allowance'] + $payRollInput['shift_allowance'] + $payRollInput['other_allowance'];
                    $payRollInput['esi'] = ($salary >= 21000) ? 0 : (($salary / 100) * $percentage->esi);
                    $payRollInput['epf'] = ($payRollInput['basic'] >= 15000) ? 1800 : (($payRollInput['basic'] / 100) * $percentage->pf);
                    $payRollInput['tds_deduction'] = 0;
                    $payRollInput['other_deduction'] = 0;
                    $payRollInput['medi_claim'] = $employee->insurance;
                    $payRollInput['total_deduction'] = $payRollInput['esi'] + $payRollInput['epf'] + $payRollInput['tds_deduction'] + $payRollInput['other_deduction'] + $payRollInput['medi_claim'];
                    $payRollInput['net_salary'] = $payRollInput['total_earnings'] - $payRollInput['total_deduction'];
                    $payRollInput['company_epf'] = ($payRollInput['basic'] >= 15000) ? 1950 : (($payRollInput['basic'] / 100) * $percentage->company_pf);
                    $payRollInput['company_esi'] = ($salary >= 21000) ? 0 : (($salary / 100) * $percentage->company_esi);
                    $payRollInput['bank_name'] = $employee->bank ? $employee->bank->name : '-';
                    $payRollInput['account_number'] = $employee->account_number;
                    $payRollInput['ifsc_code'] = $employee->ifsc;
                    $payRollInput['comments'] = '';

                    Payroll::create($payRollInput);
                }
            }

            return response(['status' => 'success', 'message' => 'PaySlip Generated Successfully!']);
        } catch (\Exception $exception) {
            info('Error::Place@PayrollController@generatePayslipForAllEmployees - ' . $exception->getMessage());
            return response(['status' => 'warning']);
        }
    }

    //Export Payroll
    public function exportPayroll(Request $request){

        return Excel::download(new PayrollsExport($request->input('monthYear')), 'payroll'.$request->input('monthYear').'.xlsx');

    }
}
