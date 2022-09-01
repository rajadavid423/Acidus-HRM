@extends('layouts.layout')

@section('content')
    <style>
        .redcolor{
            color: red;
        }
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            {{--        Employee start--}}
            <div class="col-md-12">


                {{--Employee title--}}
                <div class="titles text-center bg-emp-title p-2">
                    <h6>@if(!$user)Add @else Update @endif Employee</h6>
                </div>

                <hr class="mt-0 title_hr">

                <form autocomplete="off" method="POST" class="form-validate"
                      action="{{ $user ? route('employee.update', $user->id) : route('employee.store') }}">
                    @csrf
                    @if($user) @method('PUT') @endif
                {{--Employee Basic Details form--}}
                <div class="Employee_form mt-4">
                    <h6 class="mb-4">Basic Details :</h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Employee Name <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="text" class="form-control form-control-sm list-group-item-Employee-secondary @error('name') is-invalid @enderror" placeholder="Enter Employee Name" name="name" id="" value="{{ $user ? old('name', $user->name) : old('name') }}" required>
                                        @error('name')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="DesignationSelect" class="col-md-5 col-sm-4">Designation</label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('designation_id') is-invalid @enderror" id="DesignationSelect" name="designation_id">
                                            <option selected disabled value="">Select a Designation</option>
                                            @foreach($designations as $designation)
                                                <option value="{{$designation->id}}" {{ old('designation_id') == $designation->id ? 'selected' : (($user && $user->designation_id == $designation->id)  ? 'selected' : '') }}>{{ $designation->designation_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('designation_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Employee ID <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input autocomplete="off" type="text" name="employee_id" class="form-control form-control-sm list-group-item-Employee-secondary @error('employee_id') is-invalid @enderror" placeholder="Enter Employee ID" value="{{ $user ? old('employee_id', $user->employee_id) : (old('employee_id') ?? '') }}" required>
                                        @error('employee_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ShiftSelect" class="col-md-5 col-sm-4">Shift</label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('shift_id') is-invalid @enderror" id="ShiftSelect" name="shift_id">
                                            <option selected disabled value="">Select a Shift</option>
                                            @foreach($shifts as $shift)
                                                <option value="{{$shift->id}}" {{ old('shift_id') == $shift->id ? 'selected' : (($user && $user->shift_id == $shift->id)  ? 'selected' : '') }}>{{ $shift->shift_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('shift_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Date of Birth </label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="date" name="dob" class="form-control form-control-sm list-group-item-Employee-secondary @error('dob') is-invalid @enderror" placeholder="Enter Employee Name" id="" value="{{ $user ? old('dob', $user->dob) : old('dob') }}">
                                        @error('dob')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ProcessSelect" class="col-md-5 col-sm-4">Process</label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('process_id') is-invalid @enderror" id="ProcessSelect" name="process_id">
                                            <option selected disabled value="">Select a Process</option>
                                            @foreach($process as $proces)
                                                <option value="{{$proces->id}}" {{ old('process_id') == $proces->id ? 'selected' : (($user && $user->process_id == $proces->id)  ? 'selected' : '') }}>{{ $proces->process_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('process_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="GenderSelect" class="col-md-5 col-sm-4">Gender <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('gender') is-invalid @enderror" id="GenderSelect" name="gender" required>
                                            <option selected disabled value="">Select a Gender</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : (($user && $user->gender == 'Male')  ? 'selected' : '') }}>Male</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : (($user && $user->gender == 'Female')  ? 'selected' : '') }}>Female</option>
                                        </select>
                                        @error('gender')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="teamSelect" class="col-md-5 col-sm-4">Team</label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('team_id') is-invalid @enderror" id="teamSelect" name="team_id">
                                            <option selected disabled value="">Select a Team</option>
                                            @foreach($teams as $team)
                                                <option value="{{$team->id}}" {{ old('team_id') == $team->id ? 'selected' : (($user && $user->team_id == $team->id)  ? 'selected' : '') }}>{{ $team->team_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('team_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ClientSelect" class="col-md-5 col-sm-4">Client</label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('client_id') is-invalid @enderror" id="ClientSelect" name="client_id">
                                            <option selected disabled value="">Select a Client</option>
                                            @foreach($clients as $client)
                                                <option value="{{$client->id}}" {{ old('client_id') == $client->id ? 'selected' : (($user && $user->client_id == $client->id)  ? 'selected' : '') }}>{{ $client->client_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Phone Number</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" name="phone_number" class="form-control form-control-sm list-group-item-Employee-secondary @error('phone_number') is-invalid @enderror" placeholder="Enter Phone Number" id="" value="{{ $user ? old('phone_number', $user->phone_number) : old('phone_number') }}">
                                        @error('phone_number')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Email ID <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="email" name="email" class="form-control form-control-sm list-group-item-Employee-secondary @error('email') is-invalid @enderror" placeholder="Enter Email ID" id="" value="{{ $user ? old('email', $user->email) : old('email') }}" required>
                                        @error('email')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Aadhar Number</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" name="aadhar_number" class="form-control form-control-sm list-group-item-Employee-secondary @error('aadhar_number') is-invalid @enderror" placeholder="Enter Aadhar Number" id="" value="{{ $user ? old('aadhar_number', $user->aadhar_number) : old('aadhar_number') }}">
                                        @error('aadhar_number')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">ESI</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="text" name="esi_number" class="form-control form-control-sm list-group-item-Employee-secondary @error('esi_number') is-invalid @enderror" placeholder="Enter ESI" id="" value="{{ $user ? old('esi_number', $user->esi_number) : old('esi_number') }}">
                                        @error('esi_number')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">UAN</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="text" name="uan_number" class="form-control form-control-sm list-group-item-Employee-secondary @error('uan_number') is-invalid @enderror" placeholder="Enter UAN" id="" value="{{ $user ? old('uan_number', $user->uan_number) : old('uan_number') }}">
                                        @error('uan_number')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Date of Joining <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="date" name="date_of_joining" class="form-control form-control-sm list-group-item-Employee-secondary @error('date_of_joining') is-invalid @enderror" placeholder="Enter Employee Name" id="" value="{{ $user ? old('date_of_joining', $user->date_of_joining) : old('date_of_joining') }}" required>
                                        @error('date_of_joining')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Date of Leaving</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="date" name="date_of_leaving" class="form-control form-control-sm list-group-item-Employee-secondary @error('date_of_leaving') is-invalid @enderror" placeholder="Enter Employee Name" id="" value="{{ $user ? old('date_of_leaving', $user->date_of_leaving) : old('date_of_leaving') }}">
                                        @error('date_of_leaving')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Casual Leave <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="0.5" class="form-control form-control-sm list-group-item-Employee-secondary @error('cl') is-invalid @enderror" placeholder="CL days" id="" name="cl" value="{{ $user ? old('cl', $user->cl) : old('cl') }}" required>
                                        @error('cl')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Sick Leave <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="0.5" class="form-control form-control-sm list-group-item-Employee-secondary @error('sl') is-invalid @enderror" placeholder="SL days" id="" name="sl" value="{{ $user ? old('sl', $user->sl) : old('sl') }}" required>
                                        @error('sl')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Paid Leave <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="0.5" class="form-control form-control-sm list-group-item-Employee-secondary @error('pl') is-invalid @enderror" placeholder="PL days" id="" name="pl" value="{{ $user ? old('pl', $user->pl) : old('pl') }}" required>
                                        @error('pl')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="assignrole" class="col-md-5 col-sm-4">Roles <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('assignRole') is-invalid @enderror" id="assignRole" name="assignRole" required>
                                            <option selected disabled value="">Select a Role</option>
                                            @foreach($roles as $role)
                                                @if($user)
                                                   <option value="{{ $role->id  }}" {{ ($user->role && $user->role->name==$role->name) ? 'selected' : ''  }} >{{  $role->name ?? '-'  }}</option>
                                                @else
                                                   <option value="{{ $role->id  }}" >{{  $role->name  }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ClientSelect" class="col-md-5 col-sm-4">Branch</label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('branch_id') is-invalid @enderror" id="BranchSelect" name="branch_id">
                                            <option selected disabled value="">Select a Branch</option>
                                            @foreach($branches as $branch)
                                                <option value="{{$branch->id}}" {{ old('branch_id') == $branch->id ? 'selected' : (($user && $user->branch_id == $branch->id)  ? 'selected' : '') }}>{{ $branch->branch_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('branch_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
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
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Salary <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" name="salary" id="salary_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('salary') is-invalid @enderror" placeholder="Enter Salary Amount" value="{{ $user ? old('salary', $user->salary) : old('salary') }}" required>
                                        @error('salary')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Gross <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" name="gross" id="gross_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('gross') is-invalid @enderror" placeholder="Enter Gross" value="{{ $user ? old('gross', $user->gross) : old('gross') }}" readonly required style="background-color: white">
                                        @error('gross')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Basic <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" required step="any" name="basic" id="basic_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('basic') is-invalid @enderror" placeholder="Enter Basic Amount" value="{{ $user ? old('basic', $user->basic) : old('basic') }}" readonly style="background-color: white">
                                        @error('basic')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">HRA <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" required  name="hra" id="hra_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('hra') is-invalid @enderror" placeholder="Enter HRA" value="{{ $user ? old('hra', $user->hra) : old('hra') }}" readonly style="background-color: white">
                                        @error('hra')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">ESI <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" name="esi" id="esi_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('esi') is-invalid @enderror" placeholder="Enter ESI" value="{{ $user ? old('esi', $user->esi) : old('esi') }}" readonly style="background-color: white" required>
                                        @error('esi')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">EPF <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" name="pf" id="pf_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('pf') is-invalid @enderror" placeholder="Enter PF" value="{{ $user ? old('pf', $user->pf) : old('pf') }}" readonly style="background-color: white" required>
                                        @error('pf')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Insurance <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" name="insurance" step="any" id="ins_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('insurance') is-invalid @enderror" placeholder="Enter INS Employee" value="{{ $user ? old('insurance', $user->insurance) : old('insurance') }}" required>
                                        @error('insurance')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Net Amount <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" name="net_amount" step="any" id="net_amount" onchange="calculateNetSalaryAmount()" class="form-control form-control-sm list-group-item-Employee-secondary @error('net_amount') is-invalid @enderror" placeholder="Enter Net Amount" value="{{ $user ? old('net_amount', $user->net_amount) : old('net_amount') }}" readonly style="background-color: white" required>
                                        @error('net_amount')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
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
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Bank Name <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <select class="form-control form-control-sm @error('bank_id') is-invalid @enderror" id="BankSelect" name="bank_id">
                                            <option selected disabled value="">Select a Bank</option>
                                            @foreach($banks as $bank)
                                                <option value="{{$bank->id}}" {{ old('bank_id') == $bank->id ? 'selected' : (($user && $user->bank_id == $bank->id)  ? 'selected' : '') }}>{{ $bank->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('bank_id')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Account Number <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="text" name="account_number" class="form-control form-control-sm list-group-item-Employee-secondary @error('account_number') is-invalid @enderror" placeholder="Enter Account Number" id="" value="{{ $user ? old('account_number', $user->account_number) : old('account_number') }}" required>
                                        @error('account_number')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">IFSC Code <span class="redcolor">*</span></label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="text" name="ifsc" class="form-control form-control-sm list-group-item-Employee-secondary @error('ifsc') is-invalid @enderror" placeholder="Enter IFSC Code" id="" value="{{ $user ? old('ifsc', $user->ifsc) : old('ifsc') }}" required>
                                        @error('ifsc')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-md-5 col-sm-4">Password @if(!$user) <span class="redcolor">*</span> @endif </label>
                                <div class="col-md-7 col-sm-8">
                                    <input type="password" name="password" class="form-control form-control-sm list-group-item-Employee-secondary @error('password') is-invalid @enderror" placeholder="Enter password" id="" @if(!$user) required @endif>
                                    @error('password')
                                    <span class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div><div class="col-md-6">
                            <div class="form-group row">
                                <label for="inputPassword" class="col-md-5 col-sm-4">Confirm Password @if(!$user) <span class="redcolor">*</span> @endif </label>
                                <div class="col-md-7 col-sm-8">
                                    <input type="password" name="password_confirmation" class="form-control form-control-sm list-group-item-Employee-secondary @error('password_confirmation') is-invalid @enderror" placeholder="Enter confirm password" id="" @if(!$user) required @endif>
                                    @error('password_confirmation')
                                    <span class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="modal-footer border-0 mt-5 w-100 justify-content-center">
                            <a href="{{ route('Employee.index') }}"><button type="button" class="btn btn-outline-shift-primary btn-sm px-4">Close</button></a>
                            <button type="submit" class="btn btn-shift-primary btn-sm px-4">Submit</button>
                        </div>

                </div>
                </form>
                {{--Employee Bank Details  form end--}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var basicPercentage = {{ $percentage->basic }};
        var hraPercentage = {{ $percentage->hra }};
        var esiPercentage = {{ $percentage->esi }};
        var epfPercentage = {{ $percentage->pf }};

        function calculateNetSalaryAmount() {
            var salary = $('#salary_amount').val();
            $('#gross_amount').val(parseFloat(salary).toFixed(2));
            var basic = (parseFloat(salary)/100) * basicPercentage;
            $('#basic_amount').val(parseFloat(basic).toFixed(2));
            $('#hra_amount').val(((parseFloat(salary)/100) * hraPercentage).toFixed(2));

            if(parseFloat(salary) >= 21000.00) {
                $('#esi_amount').val(0);
            } else {
                $('#esi_amount').val(((parseFloat(salary) / 100) * esiPercentage).toFixed(2));
            }

            if(parseFloat(basic) >= 15000.00) {
                $('#pf_amount').val(1800);
            } else {
                $('#pf_amount').val(((parseFloat(basic) / 100) * epfPercentage).toFixed(2));
            }

            var insurance = $('#ins_amount').val();
            if (insurance === '' || insurance === null) {
                $('#ins_amount').val(0);
            }

            $('#net_amount').val((parseFloat($('#basic_amount').val()) + parseFloat($('#hra_amount').val())) - (parseFloat($('#esi_amount').val()) + parseFloat($('#pf_amount').val()) + parseFloat($('#ins_amount').val())));
        }

    </script>
@endsection
