<?php

namespace App\Console\Commands;

use App\Models\Leave;
use App\Models\LeaveRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class EmployeeMonthlyLeaveUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Employee-Monthly-Leave-Update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description - Employee Monthly Leave Update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $today = now()->format('d');
        DB::beginTransaction();
        try {
            if ($today == '26') {
                $this->updateExistingUserLeaveRecords();
                $this->addMonthlyLeavesForEligibleUsers();
                $this->createCurrentOpeningLeaveRecordForAllUsers();
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            info('Error::Place@EmployeeMonthlyLeaveUpdate - ' . $exception->getMessage());
        }
    }

    public function updateExistingUserLeaveRecords()
    {
        $payTerm = now()->format('m-Y');
        $todayMonth = now()->format('m');
        $thisYear = now()->format('Y');

        $leaveRecords = LeaveRecord::where('pay_term', $payTerm)->get();
        foreach ($leaveRecords as $leaveRecord) {

            $startDate = Carbon::createFromDate($thisYear, $todayMonth, 26)->subMonths(1);
            $endDate = Carbon::createFromDate($thisYear, $todayMonth, 25);

            $leaveRecordUpdate['consumed_cl'] = Leave::where('user_id', $leaveRecord->user_id)
                ->whereBetween('start_date', [$startDate, $endDate])
                ->whereBetween('end_date', [$startDate, $endDate])
                ->where('status', 'Approved')
                ->sum('cl_count');

            $leaveRecordUpdate['consumed_sl'] = Leave::where('user_id', $leaveRecord->user_id)
                ->whereBetween('start_date', [$startDate, $endDate])
                ->whereBetween('end_date', [$startDate, $endDate])
                ->where('status', 'Approved')
                ->sum('sl_count');

            $leaveRecordUpdate['consumed_pl'] = Leave::where('user_id', $leaveRecord->user_id)
                ->whereBetween('start_date', [$startDate, $endDate])
                ->whereBetween('end_date', [$startDate, $endDate])
                ->where('status', 'Approved')
                ->sum('pl_count');

            $leaveRecordUpdate['closing_cl'] = $leaveRecord->opening_cl - $leaveRecordUpdate['consumed_cl'];
            $leaveRecordUpdate['closing_sl'] = $leaveRecord->opening_sl - $leaveRecordUpdate['consumed_sl'];
            $leaveRecordUpdate['closing_pl'] = $leaveRecord->opening_pl - $leaveRecordUpdate['consumed_pl'];

            $leaveRecord->update($leaveRecordUpdate);
        }
    }

    public function addMonthlyLeavesForEligibleUsers()
    {
        $beforeTwoMonth = Carbon::now()->subMonths(2);
        $eligibleEmployees = User::where('date_of_joining', '<=', $beforeTwoMonth)->get();
        $todayMonth = now()->format('m');

        foreach ($eligibleEmployees as $eligibleEmployee) {

            if ($todayMonth == '01') {
                //First Month
                $employeeInput['cl'] = 1;
                $employeeInput['sl'] = 0.5;
                $employeeInput['pl'] = $eligibleEmployee->pl + 0.5;

            } else {
                $employeeInput['cl'] = $eligibleEmployee->cl + 1;
                $employeeInput['sl'] = $eligibleEmployee->sl + 0.5;
                $employeeInput['pl'] = $eligibleEmployee->pl + 0.5;
            }

            $user = User::find($eligibleEmployee->id);
            $user->update($employeeInput);
        }
    }

    public function createCurrentOpeningLeaveRecordForAllUsers()
    {
        $payTerm = now()->addMonth()->format('m-Y');
        foreach (User::all() as $user) {
            $leaveRecordNextMonth['user_id'] = $user->id;
            $leaveRecordNextMonth['pay_term'] = $payTerm;
            $leaveRecordNextMonth['opening_cl'] = $user->cl;
            $leaveRecordNextMonth['opening_sl'] = $user->sl;
            $leaveRecordNextMonth['opening_pl'] = $user->pl;

            LeaveRecord::create($leaveRecordNextMonth);
        }
    }
}
