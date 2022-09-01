@extends('layouts.layout')

@section('content')

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
                    <form action="{{ route('salary-percentage.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Basic Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" class="form-control form-control-sm list-group-item-Employee-secondary @error('basic') is-invalid @enderror"
                                               placeholder="Basic %" id="" name="basic" value="{{ $salaryPercentage ? old('basic', $salaryPercentage->basic) : old('basic') }}" >
                                        @error('basic')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">HRA Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" class="form-control form-control-sm list-group-item-Employee-secondary @error('hra') is-invalid @enderror"
                                               placeholder="HRA %" id="" name="hra" value="{{ $salaryPercentage ? old('hra', $salaryPercentage->hra) : old('hra') }}">
                                        @error('hra')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">ESI Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" class="form-control form-control-sm list-group-item-Employee-secondary @error('esi') is-invalid @enderror"
                                               placeholder="ESI %" id="" name="esi" value="{{ $salaryPercentage ? old('esi', $salaryPercentage->esi) : old('esi') }}">
                                        @error('esi')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">PF Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" class="form-control form-control-sm list-group-item-Employee-secondary @error('pf') is-invalid @enderror"
                                               placeholder="PF %" id="" name="pf" value="{{ $salaryPercentage ? old('pf', $salaryPercentage->pf) : old('pf') }}">
                                        @error('pf')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Company ESI Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" class="form-control form-control-sm list-group-item-Employee-secondary @error('company_esi') is-invalid @enderror"
                                               placeholder="Company ESI %" id="" name="company_esi" value="{{ $salaryPercentage ? old('company_esi', $salaryPercentage->company_esi) : old('company_esi') }}">
                                        @error('company_esi')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-md-5 col-sm-4">Company PF Percentage</label>
                                    <div class="col-md-7 col-sm-8">
                                        <input type="number" step="any" class="form-control form-control-sm list-group-item-Employee-secondary @error('company_pf') is-invalid @enderror"
                                               placeholder="Company PF %" id="" name="company_pf" value="{{ $salaryPercentage ? old('company_pf', $salaryPercentage->company_pf) : old('company_pf') }}">
                                        @error('company_pf')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 mt-5 w-100 justify-content-center">
                            <a href="{{ route('salary-percentage.show') }}"><button type="button" class="btn btn-outline-shift-primary btn-sm px-4">Cancel</button></a>
                            <button type="submit" class="btn btn-shift-primary btn-sm px-4">Submit</button>
                        </div>

                    </form>
                </div>

                {{--Employee Bank Details  form end--}}
            </div>
        </div>
    </div>




@endsection
