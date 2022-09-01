<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        $users = User::with('designation', 'shift', 'process', 'client', 'team', 'branch', 'bank')->get();

        $i = 0;
        $data = [];
        foreach ($users as $user) {
            $data[$i]['employee_id'] = $user->employee_id ?? '-';
            $data[$i]['employee_name'] = $user->name ?? '-';
            $data[$i]['designation'] = $user->designation ? $user->designation->designation_name : '-';
            $data[$i]['shift'] = $user->shift ? $user->shift->shift_name : '-';
            $data[$i]['dob'] = $user->dob ?? '-';
            $data[$i]['process'] = $user->process ? $user->process->process_name : '-';
            $data[$i]['gender'] = $user->gender ?? '-';
            $data[$i]['team'] = $user->team ? $user->team->team_name : '-';
            $data[$i]['client'] = $user->client ? $user->client->client_name : '-';
            $data[$i]['branch'] = $user->branch ? $user->branch->branch_name : '-';
            $data[$i]['phone_number'] = $user->phone_number ?? '-';
            $data[$i]['email'] = $user->email ?? '-';
            $data[$i]['aadhar_number'] = $user->aadhar_number ?? '-';
            $data[$i]['esi_number'] = $user->esi_number ?? '-';
            $data[$i]['uan_number'] = $user->uan_number ?? '-';
            $data[$i]['date_of_joining'] = $user->date_of_joining ?? '-';
            $data[$i]['date_of_leaving'] = $user->date_of_leaving ?? '-';
            $data[$i]['cl'] = $user->cl ?? '-';
            $data[$i]['sl'] = $user->sl ?? '-';
            $data[$i]['pl'] = $user->pl ?? '-';
            $data[$i]['salary'] = $user->salary ?? '-';
            $data[$i]['gross'] = $user->gross ?? '-';
            $data[$i]['basic'] = $user->basic ?? '-';
            $data[$i]['hra'] = $user->hra ?? '-';
            $data[$i]['esi'] = $user->esi ?? '-';
            $data[$i]['pf'] = $user->pf ?? '-';
            $data[$i]['insurance'] = $user->insurance ?? '-';
            $data[$i]['net_amount'] = $user->net_amount ?? '-';
            $data[$i]['bank_name'] = $user->bank ? $user->bank->name : '-';
            $data[$i]['account_number'] = $user->account_number ?? '-';
            $data[$i]['ifsc'] = $user->ifsc ?? '-';

            $i++;

        }
        return collect($data);
    }

    public function headings(): array
    {
        return ['Employee Id', 'Employee Name', 'Designation', 'Shift', 'DOB', 'Process', 'Gender', 'Team', 'Client',
            'Branch', 'Phone Number', 'Email', 'Aadhar Number', 'Esi Number', 'Uan Number', 'Date of Joining', 'Date of Leaving',
            'CL', 'SL', 'PL', 'Salary', 'Gross', 'Basic', 'HRA', 'ESI', 'PF', 'Insurance', 'Net Amount', 'Bank Name',
            'Account Number', 'IFSC',
        ];
    }
}
