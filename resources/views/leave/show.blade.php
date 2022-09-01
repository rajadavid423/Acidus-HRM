@extends('layouts.layout')
<style>
    #showForm {
        pointer-events: none;
    }
</style>
@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        Employee start--}}
            <div class="col-md-12">

                {{--Employee title--}}
                <div class="titles text-center bg-emp-title p-2">
                    <h6>Leave Apply</h6>
                </div>

                <hr class="mt-0 title_hr">
                {{--Employee Basic Details form--}}
                <div class="Employee_form mt-4">
                    <form action="" method="POST" id="showForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4">User Name</label>
                                    <div class="col-sm-8">
                                        <input class="form-control form-control-sm list-group-item-Employee-secondary @error('user_id') is-invalid @enderror"
                                               id="employeeSelect2" name="user_id" value="{{ $viewLeave->userDetail->name ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4">Leave Type</label>
                                    <div class="col-sm-8">
                                        <input class="form-control form-control-sm list-group-item-Employee-secondary @error('leave_type') is-invalid @enderror"
                                                id="" name="leave_type" value="{{ snakeCaseToTitleCase($viewLeave->leave_type) ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4">Leave Duration</label>
                                    <div class="col-sm-8">
                                        <input class="form-control form-control-sm list-group-item-Employee-secondary @error('duration') is-invalid @enderror"
                                               id="duration" name="duration" value="{{ snakeCaseToTitleCase($viewLeave->duration) ?? '' }}">

                                        @error('duration')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4">Start Date</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control form-control-sm list-group-item-Employee-secondary @error('start_date') is-invalid @enderror"
                                               id="start_date" name="start_date" value="{{ $viewLeave ? old('start_date', $viewLeave->start_date) : old('start_date') }}">
                                        @error('start_date')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4">End Date</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control form-control-sm list-group-item-Employee-secondary @error('end_date') is-invalid @enderror"
                                               id="end_date" name="end_date" value="{{ $viewLeave ? old('end_date', $viewLeave->end_date) : old('end_date') }}">
                                        @error('end_date')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4">No of Days</label>
                                    <div class="col-sm-8">
                                        <input style="background-color: #ffffff;" type="number" step="0.5" class="form-control form-control-sm list-group-item-Employee-secondary @error('no_of_days') is-invalid @enderror"
                                               id="no_of_days" name="no_of_days" value="{{ $viewLeave ? old('no_of_days', $viewLeave->no_of_days) : old('no_of_days') }}" readonly>
                                        @error('no_of_days')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4">Leave Reason</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm list-group-item-Employee-secondary @error('reason') is-invalid @enderror"
                                                  name="reason">{{ $viewLeave ? old('reason', $viewLeave->reason) : old('reason') }}</textarea>
                                        @error('reason')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-4">Leave Request Status</label>
                                    <div class="col-sm-8">
                                        <input style="background-color: #ffffff;" type="text" step="0.5" class="form-control form-control-sm list-group-item-Employee-secondary @error('status') is-invalid @enderror"
                                               id="status" name="status" value="{{ $viewLeave ? old('status', $viewLeave->status) : old('status') }}" readonly>
                                        @error('status')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($viewLeave->reject_reason != null)
                                <div class="form-group row">
                                    <label class="col-sm-4">Leave Reject Reason</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control form-control-sm list-group-item-Employee-secondary @error('reject_reason') is-invalid @enderror"
                                                  name="reject_reason">{{ $viewLeave ? old('reject_reason', $viewLeave->reject_reason) : old('reject_reason') }}</textarea>
                                        @error('reject_reason')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>


                    </form>
                    <div class="modal-footer border-0 mt-5 w-100 justify-content-center">
                        <a href="{{ route('leave.index') }}"><button type="button" class="btn btn-outline-shift-primary btn-sm px-4">Cancel</button></a>
                    </div>
                </div>

                {{--Employee Bank Details  form end--}}
            </div>
        </div>
    </div>
@endsection

