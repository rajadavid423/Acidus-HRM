@extends('layouts.layout')

@section('content')
    @include('common_script.alert_script')
    <div class="container-fluid">
        <div class="row">
            {{--        Employee start--}}
            <div class="col-md-12">

                {{--Employee title--}}
                <div class="titles text-center bg-emp-title p-2">
                    <h6>Salary  Percentage Details</h6>
                </div>

                <hr class="mt-0 title_hr">

                {{--Employee Basic Details form--}}
                <div class="Employee_form mt-4">
                    <h6 class="mb-4">Percentage Details :</h6>
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Basic Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" class="form-control form-control-sm list-group-item-Employee-secondary"
                                               placeholder="Basic %" id="" name="basic" value="{{ $salaryPercentage ? $salaryPercentage->basic : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">HRA Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" class="form-control form-control-sm list-group-item-Employee-secondary"
                                               placeholder="HRA %" id="" name="hra" value="{{ $salaryPercentage ? $salaryPercentage->hra : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">ESI Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" class="form-control form-control-sm list-group-item-Employee-secondary"
                                               placeholder="ESI %" id="" name="esi" value="{{ $salaryPercentage ? $salaryPercentage->esi : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">PF Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" class="form-control form-control-sm list-group-item-Employee-secondary"
                                               placeholder="PF %" id="" name="pf" value="{{ $salaryPercentage ? $salaryPercentage->pf : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Company ESI Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" class="form-control form-control-sm list-group-item-Employee-secondary"
                                               placeholder="Company ESI %" id="" name="company_esi" value="{{ $salaryPercentage ? $salaryPercentage->company_esi : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Company PF Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" class="form-control form-control-sm list-group-item-Employee-secondary"
                                               placeholder="Company PF %" id="" name="company_pf" value="{{ $salaryPercentage ? $salaryPercentage->company_pf : '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 mt-5 w-100 justify-content-center">
                            <a href="{{ route('salary-percentage.edit') }}"><button type="button" class="btn btn-shift-primary btn-sm px-4">Edit</button></a>
                        </div>

                    </form>
                </div>

                <hr>
                <div class="mt-3">
                    <h4>Notes:</h4>
                    <p>1. Basic -> % from the Gross salary.</p>
                    <p>2. HRA -> % from the Gross salary.</p>
                    <p>3. ESI -> % from the Gross salary & Gross salary is more than 21,000 ESI is not applicable.</p>
                    <p>4. PF -> % from the Basic salary & If basic salary is more than 15,000 then standard PF amount is 1,800.</p>
                    <p>4. Company ESI -> % from the Gross salary & Gross salary is more than 21,000 ESI is not applicable.</p>
                    <p>4. Company PF -> % from the Basic salary & If basic salary is more than 15,000 then standard PF amount is 1,800.</p>
                </div>
                {{--Employee Bank Details  form end--}}
            </div>
        </div>
    </div>
@endsection
