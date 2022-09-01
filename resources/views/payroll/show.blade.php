@extends('layouts.layout')

@section('content')
<style>
    .inputBlock {
        pointer-events: none;
    }
</style>

    <div class="container-fluid">
        <div class="row">
            <form onkeydown="return false">
                @csrf
            <div class="col-md-12">
                <div class="titles text-center bg-emp-title p-2">
                    <h6>Show Payslip</h6>
                </div>

                <hr class="mt-0 title_hr">

                <div class="mt-3">
                    <h6>Basic Details :</h6>
                        {{--Basic Details--}}
                        <div class="row">
                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Employee Name :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm"
                                               name="name" onkeydown="return false"
                                               value="{{ $editPayroll->userDetail ? old('name', $editPayroll->userDetail->name) : '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Month :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" onkeydown="return false"
                                               name="period" value="{{  $editPayroll ? \Carbon\Carbon::parse($editPayroll->month)->format('F Y') :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Working Days :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.5" class="form-control form-control-sm" onkeydown="return false"
                                               name="worked_days" value="{{ $editPayroll ? old('worked_days',$editPayroll->working_days) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Present Days :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.5" class="form-control form-control-sm" onkeydown="return false"
                                               name="present_days" value="{{ $editPayroll ? old('present_days',$editPayroll->days_present) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">CL :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" onkeydown="return false"
                                               name="cl_days" value="{{ $editPayroll->userDetail ? old('cl_days',$editPayroll->userDetail->cl) :  '' }}" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">SL :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" name="sl_days" onkeydown="return false"
                                               value="{{ $editPayroll->userDetail ? old('sl_days',$editPayroll->userDetail->sl) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">PL :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" name="pl_days" onkeydown="return false"
                                               value="{{ $editPayroll->userDetail ? old('pl_days',$editPayroll->userDetail->pl) :  '' }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{--Basic Details end--}}

                        <hr class="my-3">

                        {{--Earnings Details--}}
                        <h6 class="mb-4">Earnings Details :</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Salary Amount :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" name="dummy_salary" onkeydown="return false"
                                               value="{{ $editPayroll ? old('dummy_salary',$editPayroll->gross) :  '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Gross :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" id="dummy_gross" name="dummy_gross" onkeydown="return false"
                                        value="{{ $editPayroll ? old('dummy_gross',$editPayroll->gross) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Basic Amount :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm earningClass" id="dummy_basic" name="dummy_basic" onkeydown="return false"
                                        value="{{ $editPayroll ? old('dummy_basic',$editPayroll->basic) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">HRA :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm earningClass" id="dummy_hra" name="dummy_hra" onkeydown="return false"
                                        value="{{ $editPayroll ? old('dummy_hra',$editPayroll->hra) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Special Day Allowance  :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm inputBlock @error('special_day_allowance') is-invalid @enderror" id="special_day_allowance" name="special_day_allowance"
                                               value="{{ $editPayroll ? old('special_day_allowance',$editPayroll->special_day_allowance) :  old('special_day_allowance') }}">
                                        @error('special_day_allowance')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Special Allowance  :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm inputBlock @error('special_allowance') is-invalid @enderror" id="special_allowance" name="special_allowance"
                                               value="{{ $editPayroll ? old('special_allowance',$editPayroll->special_allowance) :  old('special_allowance') }}">
                                        @error('special_allowance')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Shift Allowance  :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm inputBlock @error('shift_allowance') is-invalid @enderror" id="shift_allowance" name="shift_allowance"
                                               value="{{ $editPayroll ? old('shift_allowance',$editPayroll->shift_allowance) :  old('shift_allowance') }}">
                                        @error('shift_allowance')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 inputBlock" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Other Allowance  :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm inputBlock @error('other_allowance') is-invalid @enderror" id="other_allowance" name="other_allowance"
                                        value="{{ $editPayroll ? old('other_allowance',$editPayroll->other_allowance) :  old('other_allowance') }}">
                                        @error('other_allowance')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Total Earnings  :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm inputBlock @error('total_earnings') is-invalid @enderror" onkeydown="return false"
                                               id="total_earnings" name="total_earnings"
                                               value="{{ $editPayroll ? old('total_earnings',$editPayroll->total_earnings) :  '' }}">
                                        @error('total_earnings')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{--Earnings Details end--}}

                        <hr class="my-3">

                        {{--Deductions Details--}}
                        <h6 class="mb-4">Deductions Details :</h6>
                        <div class="row">

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">EPF :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm deductionClass" id="dummy_epf" name="dummy_epf" onkeydown="return false"
                                        value="{{ $editPayroll ? old('dummy_epf',$editPayroll->epf) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">ESI :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm deductionClass" id="dummy_esi" name="dummy_esi" onkeydown="return false"
                                        value="{{ $editPayroll ? old('dummy_esi',$editPayroll->esi) :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">TDS Deducted :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm @error('tds_deduction') is-invalid @enderror" id="tds_deducted"
                                               placeholder="Enter TDS Deducted" name="tds_deduction"
                                        value="{{ $editPayroll ? old('tds_deduction',$editPayroll->tds_deduction) :  '' }}">
                                        @error('tds_deduction')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Other Deducted :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm "
                                               placeholder="Enter TDS Deducted"
                                               value="{{ $editPayroll ? $editPayroll->other_deduction :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Medi Claim :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm deductionClass inputBlock" onkeydown="return false"
                                        value="{{ $editPayroll ? $editPayroll->medi_claim :  '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="email" class="my-1">Total Deductions :</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" step="0.01" class="form-control form-control-sm inputBlock @error('total_deduction') is-invalid @enderror" id="total_deduction"
                                               placeholder="Enter Total Deductions" name="total_deduction" onkeydown="return false"
                                        value="{{ $editPayroll ? old('total_deduction',$editPayroll->total_deduction) :  '' }}">
                                        @error('total_deduction')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--Deductions Details end--}}

                        <hr class="my-3">

                    <div class="row">
                        <div class="col-md-6 mb-3 inputBlock">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="email" class="my-1">Company EPF :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" step="0.01" class="form-control form-control-sm inputBlock"
                                           onkeydown="return false"
                                           value="{{ $editPayroll ? $editPayroll->company_epf :  '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 inputBlock">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="email" class="my-1">Company ESI :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" step="0.01" class="form-control form-control-sm inputBlock"
                                           onkeydown="return false"
                                           value="{{ $editPayroll ? $editPayroll->company_esi :  '' }}">
                                </div>
                            </div>
                        </div>

                    </div>

                        <hr class="my-3">

                        <div class="row">
                        <div class="col-md-6 mb-3 inputBlock">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="email" class="my-1">Net Amount :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" step="0.01" class="form-control form-control-sm inputBlock @error('net_salary') is-invalid @enderror"
                                           onkeydown="return false" id="net_salary" name="net_salary"
                                    value="{{ $editPayroll ? old('net_salary',$editPayroll->net_salary) :  '' }}">
                                    @error('net_salary')
                                    <span class="error invalid-feedback">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                            <div class="col-md-6 mb-3 inputBlock">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="comments" class="my-1">Comment :</label>
                                    </div>
                                    <div class="col-md-8">
                                    <textarea class="form-control form-control-sm @error('comments') is-invalid @enderror"
                                              onkeydown="return false" id="comments" name="comments">{{ $editPayroll ? old('comments',$editPayroll->comments) :  '' }}</textarea>
                                        @error('comments')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="row mt-5 justify-content-center">
                            <div class="col-md-4">
                                <a href="{{ route('payroll.index') }}" class="btn btn-sm px-4 mb-2 btnPrimaryCustomizeBlueOutline mr-4">
                                    Close
                                </a>

                                @can('Edit Payslip')
                                <a href="{{ route('payroll.edit', $editPayroll->id) }}" class="btn btn-sm px-4 mb-2 btnPrimaryCustomizeBlue text-light">
                                    Edit Payslip
                                </a>
                                @endcan

                            </div>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>

@endsection
