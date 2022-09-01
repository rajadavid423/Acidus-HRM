<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Process;
use App\Models\SalaryPercentage;
use App\Models\Shift;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;

class EmployeesImport implements ToModel,WithHeadingRow
{
    public function __construct()
    {
        $salaryPercentage = SalaryPercentage::first();
        $this->teamResponsiblePersonId = User::where('email', 'admin@gmail.com')->pluck('id');
        $this->basicPercentage = $salaryPercentage->basic ?? 0;
        $this->hraPercentage = $salaryPercentage->hra ?? 0;
        $this->esiPercentage = $salaryPercentage->esi ?? 0;
        $this->epfPercentage = $salaryPercentage->pf ?? 0;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(isset($row['employee_id']) && isset($row['email'])) {

            if (!User::whereEmployeeId($row['employee_id'])->exists() || !User::whereEmail($row['email'])->exists()) {
                $designation = Designation::where('designation_name', $row['designation_id'])->first();
                if ($designation != null) {
                    $row['designation_id'] = $designation->id;
                } else {
                    $designationData['designation_name'] = $row['designation_id'];
                    $designationData['description'] = $row['designation_id'];
                    $designation = Designation::create($designationData);
                    $row['designation_id'] = $designation->id;
                }
                //Shift
                $shift = Shift::where('shift_name', $row['shift_id'])->first();
                if ($shift != null) {
                    $row['shift_id'] = $shift->id;
                } else {
                    $shift = Shift::create(['shift_name' => $row['shift_id']]);
                    $row['shift_id'] = $shift->id;
                }
                //Process
                $process = Process::where('process_name', $row['process_id'])->first();
                if ($process != null) {
                    $row['process_id'] = $process->id;
                } else {
                    $processData['process_name'] = $row['process_id'];
                    $processData['description'] = $row['process_id'];
                    $process = Process::create($processData);
                    $row['process_id'] = $process->id;
                }
                //Team
                $team = Team::where('team_name', $row['team_id'])->first();
                if ($team != null) {
                    $row['team_id'] = $team->id;
                } else {
                    $teamData['team_name'] = $row['team_id'];
                    $teamData['description'] = $row['team_id'];
                    $teamData['responsible_person'] = $this->teamResponsiblePersonId;
                    $team = Team::create($teamData);
                    $row['team_id'] = $team->id;
                }
                //Client
                $client = Client::where('client_name', $row['client_id'])->first();
                if ($client != null) {
                    $row['client_id'] = $client->id;
                } else {
                    $clientData['client_name'] = $row['client_id'];
                    $clientData['description'] = $row['client_id'];
                    $client = Client::create($clientData);
                    $row['client_id'] = $client->id;
                }

                //branch
                $branch = Branch::where('branch_name', $row['branch_id'])->first();
                if ($branch != null) {
                    $row['branch_id'] = $branch->id;
                } else {
                    $branch = Branch::create(['branch_name' => $row['branch_id']]);
                    $row['branch_id'] = $branch->id;
                }

                //Required field
                $row['name'] = $row['name'] ?? '-';

                $row['dob'] = $row['dob'] ?? NULL;
                $row['date_of_joining'] = $row['date_of_joining'] ?? NULL;
                $row['date_of_leaving'] = $row['date_of_leaving'] ?? NULL;
                info('$row');
                info($row);

                $row['salary'] = $row['salary'] ?? 0;
                $row['gross'] = $row['salary'];

                $row['basic'] = round((($row['salary']/100) * $this->basicPercentage),2);
                $row['hra'] = round((($row['salary']/100) * $this->hraPercentage),2);

                if ($row['salary'] >= 21000.00){
                    $row['esi'] = 0;
                } else {
                    $row['esi'] = round((($row['salary']/100) * $this->esiPercentage),2);
                }

                if ($row['basic'] >= 15000.00){
                    $row['pf'] = 1800;
                } else {
                    $row['pf'] = round((($row['basic']/100) * $this->epfPercentage),2);
                }

                $row['insurance'] = $row['insurance'] ?? 0;
                $row['net_amount'] = (($row['basic'] + $row['hra']) - ($row['esi'] + $row['pf'] + $row['insurance']));

                //bank
                $bank = Bank::where('name', $row['bank_id'])->first();
                if ($bank != null) {
                    $row['bank_id'] = $bank->id;
                } else {
                    $bank = bank::create(['name' => $row['bank_id']]);
                    $row['bank_id'] = $bank->id;
                }

                $row['account_number'] = $row['account_number'] ?? '0';
                $row['ifsc'] = $row['ifsc'] ?? '-';
                $row['password'] = $row['password'] ? Hash::make($row['password'])  : Hash::make(1234567890);

                $employeeCreate = User::Create($row);

                //Employee Role set
                $roleid = Role::whereName('Employee')->pluck('id');
                $employeeCreate->syncRoles($roleid);
            }
        }
    }

}
