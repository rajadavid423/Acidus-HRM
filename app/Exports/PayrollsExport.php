<?php

namespace App\Exports;

use App\Models\Payroll;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayrollsExport implements FromCollection, WithHeadings
{
    protected $monthYear;

    function __construct($monthYear)
    {
        $this->monthYear = $monthYear;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $endDay = Carbon::parse($this->monthYear);
        $Date = Carbon::createFromDate($endDay->year, $endDay->month, 25)->format('Y-m-d');;

        $payRollDatas = Payroll::with('userDetail')
            ->select('user_id', 'month', 'gross', 'working_days', 'days_present', 'basic', 'hra', 'special_day_allowance',
                'special_allowance', 'shift_allowance', 'other_allowance', 'total_earnings', 'epf', 'esi', 'tds_deduction',
                'other_deduction', 'medi_claim', 'total_deduction', 'net_salary', 'company_epf', 'company_esi', 'bank_name',
                'account_number', 'ifsc_code', 'comments')
            ->where('month', '=', $Date)
            ->get();

        $i = 0;
        $data = [];
        foreach ($payRollDatas as $payRollData) {
            if ($payRollData->userDetail != null) {
                $data[$i]['user_id'] = $payRollData->userDetail ? $payRollData->userDetail->employee_id : '-';
                $data[$i]['user_name'] = $payRollData->userDetail ? $payRollData->userDetail->name : '-';
                $data[$i]['month'] = $payRollData->month ?? '-';
                $data[$i]['gross'] = $payRollData->gross ?? '-';
                $data[$i]['working_days'] = $payRollData->working_days ?? '-';
                $data[$i]['days_present'] = $payRollData->days_present ?? '-';
                $data[$i]['basic'] = $payRollData->basic ?? '-';
                $data[$i]['hra'] = $payRollData->hra ?? '-';
                $data[$i]['special_day_allowance'] = $payRollData->special_day_allowance ?? '-';
                $data[$i]['special_allowance'] = $payRollData->special_allowance ?? '-';
                $data[$i]['shift_allowance'] = $payRollData->shift_allowance ?? '-';
                $data[$i]['other_allowance'] = $payRollData->other_allowance ?? '-';
                $data[$i]['total_earnings'] = $payRollData->total_earnings ?? '-';
                $data[$i]['epf'] = $payRollData->epf ?? '-';
                $data[$i]['esi'] = $payRollData->esi ?? '-';
                $data[$i]['tds_deduction'] = $payRollData->tds_deduction ?? '-';
                $data[$i]['other_deduction'] = $payRollData->other_deduction ?? '-';
                $data[$i]['medi_claim'] = $payRollData->medi_claim ?? '-';
                $data[$i]['total_deduction'] = $payRollData->total_deduction ?? '-';
                $data[$i]['net_salary'] = $payRollData->net_salary ?? '-';
                $data[$i]['company_epf'] = $payRollData->company_epf ?? '-';
                $data[$i]['company_esi'] = $payRollData->company_esi ?? '-';
                $data[$i]['bank_name'] = $payRollData->bank_name ?? '-';
                $data[$i]['account_number'] = $payRollData->account_number ?? '-';
                $data[$i]['ifsc'] = $payRollData->ifsc_code ?? '-';
                $data[$i]['comments'] = $payRollData->comments ?? '-';
            }
            $i++;

        }

        return collect($data);
    }

    public function headings(): array
    {
        return [
            'Employee Id', 'Employee Name', 'Month', 'Gross', 'Working Days', 'Days Present', 'Basic', 'Hra',
            'Special Day Allowance', 'Special Allowance', 'Shift Allowance', 'Other Allowance', 'Total Earnings',
            'EPF', 'ESI', 'Tds Deduction', 'Other Deduction', 'Medi Claim', 'Total Deduction', 'Net Salary', 'Company EPF',
            'Company ESI', 'Bank Name', 'Account Number', 'Ifsc Code', 'Comments'
        ];
    }
}


