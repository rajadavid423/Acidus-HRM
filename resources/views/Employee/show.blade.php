@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        Employee start--}}
            <div class="col-md-12">

                {{--Employee title--}}
                <div class="titles text-center bg-emp-title p-2">
                    <h6>View Employee</h6>
                </div>

                <hr class="mt-0 title_hr">
                <div class="row">
                    <div class="col-md-1">

                    </div>

                    <div class="col-md-10">
                {{--Employee Basic Details form--}}
                <div class="Employee_form mt-4">
                    <h6 class="mb-4">Basic Details :</h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Employee Name</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->name ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="DesignationSelect" class="col-md-5 col-sm-4">Designation</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->designation ? $user->designation->designation_name : ''  }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Employee ID</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->employee_id ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ShiftSelect" class="col-md-5 col-sm-4">Shift</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->shift ? $user->shift->shift_name : '' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Date of Birth</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->dob ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ProcessSelect" class="col-md-5 col-sm-4">Process</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->process ? $user->process->process_name : '' }}

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="GenderSelect" class="col-md-5 col-sm-4">Gender</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->gender ?? '--' }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="teamSelect" class="col-md-5 col-sm-4">Team</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->team ? $user->team->team_name : '' }}

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ClientSelect" class="col-md-5 col-sm-4">Client</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->client ? $user->client->client_name : '' }}

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Phone Number</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->phone_number ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Email ID</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->email ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Aadhar Number</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->aadhar_number ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">ESI</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->esi_number ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">UAN</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->uan_number ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Date of Joining</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->date_of_joining ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Date of Leaving</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->date_of_leaving ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Casual Leave</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->cl ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Sick Leave</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->sl ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Paid Leave</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->pl ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Roles</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->role ? $user->role->name : '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Branch</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->branch ? $user->branch->branch_name : '--' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                {{--Employee Basic Details form end--}}

                <hr>

                {{--Employee Salary Details form--}}
                <div class="Employee_form mt-4">
                    <h6 class="mb-4">Salary Details :</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Salary</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->salary ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Gross</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->gross ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Basic</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->basic ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">HRA</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->hra ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">ESI</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->esi ?? '--' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">PF</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->pf ?? '--' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">INS Employee</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->insurance ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Net Amount</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->net_amount ?? '--' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                {{--Employee Salary Details form end--}}


                <hr>

                {{--Employee Bank Details  form--}}
                <div class="Employee_form mt-4">
                    <h6 class="mb-4">Bank Details :</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Bank Name</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->bank ? $user->bank->name : '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Account Number</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->account_number ?? '--' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">IFSC Code</label>
                                    <div class="col-md-7 col-sm-8">
                                        : {{ $user->ifsc ?? '--' }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer border-0 mt-5 w-100 justify-content-center">
                            <a href="{{ route('Employee.index') }}"><button type="button" class="btn btn-outline-shift-primary btn-sm px-4">Close</button></a>

                            @can('Edit Employee')
                            <a href="{{ route('employee.edit', $user->id) }}"><button type="submit" class="btn btn-shift-primary btn-sm px-4">Edit</button></a>
                            @endcan
                        </div>

                </div>
                    </div>
                    <div class="col-md-1">

                    </div>
                {{--Employee Bank Details  form end--}}
            </div>
        </div>
    </div>
    </div>




@endsection
