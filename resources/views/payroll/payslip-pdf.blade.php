<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        .earnings_table, thead, earnings_tbody {
            border: 1px solid #707070;
            /*text-align: center;*/
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Poppins, sans-serif;
        }
    </style>
</head>

<body style="font-size: 15px;">

{{--logo--}}
<table style="width: 700px">

    <tbody>
    <tr>
        <td>
            <h2 style="margin-bottom: 10px;">ACIDUS Management Solutions Pvt Ltd</h2>
        </td>
        <td rowspan="4"><img src="{{ $logo }}" style="width: 100px;margin-left: 50px"></td>
        {{--        <b> LOGO </b>--}}
        {{--        <img src="{{url('images/acidusms-logo-1.png')}}">--}}
    </tr>
    <tr>
        <td>
            <span>1702, Madura Towers, Trichy Road <br> Ramanathapuram, Coimbatore - 641045</span>
        </td>
    </tr>

    </tbody>
</table>
{{--logo end--}}

{{--title--}}
<table style="width: 700px">
    <tr style="text-align: center;">
        <td>
            <h3 style="text-decoration: underline;">Form T Payslip for the month of {{ $payroll->month ? \Carbon\Carbon::parse($payroll->month)->format('F Y') :  '-' }}</h3>
        </td>
    </tr>
</table>
{{--title end--}}

{{--Employee details--}}
<table style="width: 750px;line-height: 25px;">
    <tbody>
    <tr>
        <td>Employee Code</td>
        <td>:</td>
        <td>{{ $payroll->userDetail ? $payroll->userDetail->employee_id :  '-' }}</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td>Employee Name</td>
        <td>:</td>
        <td>{{ $payroll->userDetail ? $payroll->userDetail->name :  '-' }}</td>
    </tr>
    <tr>
        <td>Department</td>
        <td>:</td>
        <td>{{ ($payroll->userDetail && $payroll->userDetail->team) ? $payroll->userDetail->team->team_name :  '-' }}</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td>Designation</td>
        <td>:</td>
        <td>{{ ($payroll->userDetail && $payroll->userDetail->designation) ? $payroll->userDetail->designation->designation_name :  '-' }}</td>
    </tr>
    <tr>
        <td>Pay Date</td>
        <td>:</td>
        <td>{{ $payroll->month ? \Carbon\Carbon::parse($payroll->month)->format('d-m-Y') :  '-' }}</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td>Date of Joining</td>
        <td>:</td>
        <td>{{ $payroll->userDetail ? \Carbon\Carbon::parse($payroll->userDetail->date_of_joining)->format('d-m-Y') :  '-' }}</td>
    </tr>
    <tr>
        <td>Bank Name</td>
        <td>:</td>
        <td>{{ $payroll->bank_name ??  '-' }}</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td>Days Worked</td>
        <td>:</td>
        <td>{{ $payroll ? $payroll->days_present :  '-' }}</td>
    </tr>
    <tr>
        <td>Bank Acc Number</td>
        <td>:</td>
        <td> {{ $payroll->account_number ??  '-' }} </td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td>UAN No</td>
        <td>:</td>
        <td>{{ $payroll->userDetail ? $payroll->userDetail->uan_number :  '-' }}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td>ESI No</td>
        <td>:</td>
        <td>{{ $payroll->userDetail ? $payroll->userDetail->esi_number :  '-' }}</td>
    </tr>


    </tbody>
</table>
{{--Employee details end--}}

<br>

{{--Earnings & Deductions--}}
<table>
    <tbody>
    <tr>
        <td>
            {{--Earnings table--}}
            <table class="earnings_table" style="line-height: 25px">
                <thead style="background-color: #DFDFDF;border-bottom: 0px solid">
                <tr>
                    <th style="padding: 10px 0px 10px 20px;text-align: left">Earnings</th>
                    <th style="text-align: right;padding-right: 20px">Amount (Rs)</th>
                </tr>
                </thead>
                <tbody class="earnings_tbody">
{{--                <tr>--}}
{{--                    <td style="padding-left: 20px;padding-top: 10px;">Earnings</td>--}}
{{--                    <td style=" text-align: right;padding-right: 20px;padding-top: 10px">--}}
{{--                        <b>{{ $payroll ? $payroll->total_earnings :  '-' }}</b></td>--}}
{{--                </tr>--}}
                <tr>
                    <td style="padding-left: 20px;">Basic Pay</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->basic ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">HRA</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->hra ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">Special Day Allowance</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->special_day_allowance ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">Special Allowance</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->special_allowance ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">Shift Allowance</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->shift_allowance ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;padding-bottom: 20px;">Other Allowance</td>
                    <td style=" text-align: right;padding-right: 20px;padding-bottom: 20px;">
                        <b>{{ $payroll->other_allowance ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #707070;padding: 10px 0px 10px 20px;"><b>Total Earnings</b></td>
                    <td style="border-top: 1px solid #707070;text-align: right;padding-right: 20px">
                        <b>{{ $payroll->total_earnings ??  '-' }}</b></td>
                </tr>
                <tr style="border-top: 1px solid #707070;">
                    <td style="padding-left: 20px;"><b>Company's Contribution to PF@ 13%</b></td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->company_epf ??  '-' }}</b></td>
                </tr>

                <tr>
                    <td style="padding-left: 20px;"><b>Company's Contribution to ESI</b></td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->company_esi ??  '-' }}</b>
                    </td>
                </tr>
                </tbody>
            </table>
            {{--Earnings table end--}}
        </td>
        <td>
            {{--Deductions table--}}
            <table class="earnings_table" style="line-height: 25px">
                <thead style="background-color: #DFDFDF;border-bottom: 0px solid">
                <tr>
                    <th style="padding: 10px 0px 10px 20px;text-align: left">Deductions</th>
                    <th style="text-align: right;padding-right: 20px">Amount (Rs)</th>
                </tr>
                </thead>
                <tbody class="earnings_tbody">
{{--                <tr>--}}
{{--                    <td style="padding-left: 20px;"></td>--}}
{{--                    <td style=" text-align: right;padding-right: 20px">--}}
{{--                        </td>--}}
{{--                </tr>--}}
                <tr>
                    <td style="padding-left: 20px;">PF</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->epf ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">ESI</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->esi ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">TDS Deduction</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->tds_deduction ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">Other Deductions</td>
                    <td style=" text-align: right;padding-right: 20px">
                        <b>{{ $payroll->other_deduction ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;">Medi Claim</td>
                    <td style=" text-align: right;padding-right: 20px;">
                        <b>{{ $payroll->medi_claim ??  '-' }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 20px;padding-bottom: 20px;">&nbsp;</td>
                    <td style=" text-align: right;padding-right: 20px;padding-bottom: 20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #707070;padding: 10px 0px 10px 20px;"><b>Total Deductions</b></td>
                    <td style="border-top: 1px solid #707070;text-align: right;padding-right: 20px">
                        <b>{{ $payroll->total_deduction ??  '-' }}</b></td>
                </tr>
                <tr style="border-top: 1px solid #707070;vertical-align:center">
                    <td style="padding-top:15px;padding-bottom:15px;padding-left: 20px;"><b>Net Pay</b></td>
                    <td style="padding-top:15px;padding-bottom:15px;text-align: right;padding-right: 20px">
                        <b>{{ $payroll->net_salary ??  '-' }}</b></td>
                </tr>

{{--                <tr>--}}
{{--                    <td style="padding-left: 20px;">&nbsp;</td>--}}
{{--                    <td style=" text-align: right;padding-right: 20px"><b>&nbsp;</b></td>--}}
{{--                </tr>--}}
                </tbody>
            </table>
            {{--Deductions table end--}}
        </td>
    </tr>
    </tbody>
</table>
{{--Earnings & Deductions end--}}

<br>
<br>

{{--leave--}}
<table class="earnings_table">
    <thead>
    <tr>
        <th style="padding: 10px 0px 10px 0px;text-align: center;border-right: 1px solid #707070;">Leave Type</th>
        <th style="text-align: center;border-right: 1px solid #707070;">Opening Balance</th>
        <th style="text-align: center;border-right: 1px solid #707070;">Leave Applied</th>
        <th style="text-align: center;border-right: 1px solid #707070;">Balance Available</th>
        <th style="padding: 0px 20px 0px 20px;text-align: center;border-right: 1px solid #707070;">LOP</th>
    </tr>
    </thead>
    <tbody class="earnings_tbody">
    <tr>
        <td style="padding: 10px 0px 10px 0px;text-align: center;border: 1px solid #707070;">Casual Leave (CL)</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->opening_cl : '-'  }}</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->consumed_cl : '-' }}</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->closing_cl : '-' }}</td>
        <td rowspan="4" style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? ($leaveRecord->consumed_cl + $leaveRecord->consumed_pl + $leaveRecord->consumed_sl) : '-' }}</td>
    </tr>
    <tr>
        <td style="padding: 10px 0px 10px 0px;text-align: center;border: 1px solid #707070;">Paid Leave (PL)</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->opening_pl : '-'  }}</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->consumed_pl : '-' }}</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->closing_pl : '-' }}</td>
    </tr>
    <tr>
        <td style="padding: 10px 0px 10px 0px;text-align: center;border: 1px solid #707070;">Sick Leave (SL)</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->opening_sl : '-'  }}</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->consumed_sl : '-' }}</td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? $leaveRecord->closing_sl : '-' }}</td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 10px 0px 10px 35px;text-align: left;border: 1px solid #707070;"><b>Total Leave
                Available</b></td>
        <td style="text-align: center;border: 1px solid #707070;">{{ $leaveRecord ? ($leaveRecord->closing_cl + $leaveRecord->closing_pl + $leaveRecord->closing_sl) : '-' }}</td>
    </tr>
    </tbody>
</table>
{{--leave end--}}

<br>
<br>



<table>
    <tbody>
    <tr>
        <td style="text-align: center;"><p>This is system generated payslip no need of signature</p></td>
    </tr>
    </tbody>
</table>

</body>
</html>
