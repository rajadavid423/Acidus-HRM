<?php

namespace App\Jobs;

use App\Models\LeaveRecord;
use App\Models\Payroll;
use Illuminate\Support\Facades\Mail;
use PDF;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmployeePayslipMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $month;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($month)
    {
       $this->month = $month;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payrolls = Payroll::with('userDetail')->whereBetween('month', [Carbon::parse($this->month)->startOfMonth(), Carbon::parse($this->month)->endOfMonth()])->get();

        $image = public_path('images/123.png');
        // Read image path, convert to base64 encoding
        $imageData = base64_encode(file_get_contents($image));

        // Format the image SRC:  data:{mime};base64,{data};
        $logo = 'data:' . mime_content_type($image) . ';base64,' . $imageData;

        foreach ($payrolls as $payroll)
        {
            $leaveRecord = LeaveRecord::where('user_id',$payroll['user_id'])->where('pay_term',Carbon::parse($payroll->month)->format('m-Y'))->first();

            $pdf = PDF::loadView('payroll.payslip-pdf', compact('payroll', 'logo', 'leaveRecord'));

//            $pdf = PDF::loadView('payroll.payslip-pdf', compact('payroll'));
            $data = array('name' => $payroll->userDetail->name, 'month' => $this->month);
            Mail::send('payroll.payslip-email-templete', $data, function ($message) use ($payroll, $pdf) {
                $message->to($payroll->userDetail->email, 'Acidus')
                ->subject($this->month.' PaySlip')
                ->attachData($pdf->output(), "paySlip.pdf");
            });

        }
    }
}
