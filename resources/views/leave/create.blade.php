@extends('layouts.layout')

@section('content')
<style>
    .leaveBalanceClass {
        border : none;
        pointer-events: none;
        background-color: white;
    }
</style>
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
                    <form action="{{ $editLeave ? route('leave.update', $editLeave->id) : route('leave.store')  }}" method="POST">
                        @csrf
                        @if($editLeave)
                        @method('PUT')
                        @endif

                        @can('Leave Approval')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-4">Select User</label>
                                        <div class="col-sm-8">
                                            <select class="form-control form-control-sm w-100 list-group-item-Employee-secondary @error('user_id') is-invalid @enderror"
                                                    id="userSelect2" name="user_id" onchange="getEmployeeLeaveCount()">
                                                <option value="" selected disabled>Select User</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" @if(old('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                            <span class="error invalid-feedback">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <input type="hidden" class="form-control form-control-sm list-group-item-Employee-secondary @error('user_id') is-invalid @enderror"
                                                name="user_id" value="{{ auth()->user()->id ?? old('user_id') }}">
                        @endcan

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-lg-6 col-md-6 col-sm-4">Available&nbsp;CL:</label>
                                    <div class="col-lg-6 col-md-6 col-sm-8">
                                        <input class="w-100 leaveBalanceClass" id="availableCL" name="availableCL"
                                               value="{{ $employeeLeaveCount ? old('availableCL', $employeeLeaveCount->cl) : old('availableCL', 0) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-lg-6 col-md-6 col-sm-4">Available&nbsp;SL:</label>
                                    <div class="col-lg-6 col-md-6 col-sm-8">
                                        <input class="w-100 leaveBalanceClass" id="availableSL" name="availableSL"
                                               value="{{ $employeeLeaveCount ? old('availableSL', $employeeLeaveCount->sl) : old('availableSL', 0) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row">
                                    <label class="col-lg-6 col-md-6 col-sm-4">Available&nbsp;PL:</label>
                                    <div class="col-lg-6 col-md-6 col-sm-8">
                                        <input class="w-100 leaveBalanceClass" id="availablePL" name="availablePL"
                                               value="{{ $employeeLeaveCount ? old('availablePL', $employeeLeaveCount->pl) : old('availablePL', 0) }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-danger" id="msg_leave"></h6>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class=" col-sm-4">Leave Type</label>
                                    <div class=" col-sm-8">
                                        <select class="form-control form-control-sm list-group-item-Employee-secondary @error('leave_type') is-invalid @enderror"
                                               name="leave_type">
                                            <option value="casual_leave" @if(old('leave_type') == "casual_leave") selected @endif>Casual Leave</option>
                                            <option value="sick_leave" @if(old('leave_type') == "sick_leave") selected @endif>Sick Leave</option>
                                            <option value="paid_leave" @if(old('leave_type') == "paid_leave") selected @endif>Paid Leave</option>
                                        </select>
                                        @error('leave_type')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class=" col-sm-4">Leave Duration</label>
                                    <div class=" col-sm-8">
                                        <select class="form-control form-control-sm list-group-item-Employee-secondary @error('duration') is-invalid @enderror"
                                               id="duration" name="duration" onchange="validateLeaveRule()">
                                            <option value="full_day" @if(old('duration') == "full_day") selected @endif>Full Day</option>
                                            <option value="FN" @if(old('duration') == "FN") selected @endif>FN</option>
                                            <option value="AN" @if(old('duration') == "AN") selected @endif>AN</option>
                                        </select>
                                        @error('duration')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class=" col-sm-4">Start Date</label>
                                    <div class=" col-sm-8">
                                        <input type="date" class="form-control form-control-sm list-group-item-Employee-secondary @error('start_date') is-invalid @enderror"
                                               id="start_date" min="{{ (today()->format('d') >= 26) ? (now()->format('Y-m-') . '26') : (now()->subMonth()->format('Y-m-') . '26') }}" name="start_date" value="{{ $editLeave ? old('start_date', $editLeave->start_date) : old('start_date') }}" onchange="setToDateMaxAttribute()">
                                        @error('start_date')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class=" col-sm-4">End Date</label>
                                    <div class=" col-sm-8">
                                        <input type="date" class="form-control form-control-sm list-group-item-Employee-secondary @error('end_date') is-invalid @enderror"
                                               id="end_date" name="end_date" value="{{ $editLeave ? old('end_date', $editLeave->end_date) : old('end_date') }}" onchange="validateLeaveRule()">
                                        @error('end_date')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class=" col-sm-4">No of Days</label>
                                    <div class=" col-sm-8">
                                        <input style="background-color: #ffffff;" type="number" step="0.5" class="form-control form-control-sm list-group-item-Employee-secondary @error('no_of_days') is-invalid @enderror"
                                               id="no_of_days" name="no_of_days" value="{{ $editLeave ? old('no_of_days', $editLeave->no_of_days) : old('no_of_days') }}" readonly required>
                                        @error('no_of_days')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class=" col-sm-4">Leave Reason</label>
                                    <div class=" col-sm-8">
                                        <textarea class="form-control form-control-sm list-group-item-Employee-secondary @error('reason') is-invalid @enderror"
                                                  name="reason">{{ $editLeave ? old('reason', $editLeave->reason) : old('reason') }}</textarea>
                                        @error('reason')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer border-0 mt-5 w-100 justify-content-center">
                            <a href="{{ route('leave.index') }}"><button type="button" class="btn btn-outline-shift-primary btn-sm px-4">Cancel</button></a>
                            <button type="submit" class="btn btn-shift-primary btn-sm px-4">Submit</button>
                        </div>

                    </form>
                </div>

                {{--Employee Bank Details  form end--}}
            </div>
        </div>
    </div>


@endsection
@section('script')
<script>

    @can('Leave Approval')
       console.log("Leave Approval");
    @else
        callleave();
        console.log("Leave Apply");
        function callleave(){
            console.log($('#availableCL').val());
            console.log($('#availableSL').val());
            console.log($('#availablePL').val());

            if($('#availableCL').val()=='0.0' && $('#availableSL').val()=='0.0' && $('#availablePL').val()=='0.0'){
                 $("#msg_leave").html('Leave not available. if you take leave, it will be considered a loss of pay');
            }
        }
    @endcan


    function setToDateMaxAttribute(){
        let startDate = $('#start_date').val();
        let duration = $('#duration').val();
        var date = new Date(startDate);
        var day = date.getDate();
        var y = date.getFullYear();
        var m = date.getMonth() + 1;

        var lastDay;
        if(day >= 26) {
             lastDay = new Date(y, m, 25);
        } else {
             lastDay = new Date(y, m - 1, 25);
        }

        $('#end_date').prop('min',(startDate));

        var dd = lastDay.getDate();
        var mm = lastDay.getMonth() + 1; //January is 0!
        var yyyy = lastDay.getFullYear();

        if (dd < 10) {
            dd = '0' + dd;
        }

        if (mm < 10) {
            mm = '0' + mm;
        }

        lastDay = yyyy + '-' + mm + '-' + dd;

        $('#end_date').prop('max',(lastDay));
        if (duration === 'FN'){
            $('#end_date').val(startDate);
        } else if (duration === 'AN'){
            $('#end_date').val(startDate);
        } else {
            $('#end_date').val('');
        }
    }

    function validateLeaveRule(){
        let duration = $('#duration').val();
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        if (duration === 'full_day'){
            $('#end_date').prop('readonly', false);
            var diff = new Date(new Date(endDate) - new Date(startDate));

            var days = (diff/1000/60/60/24) + 1;

            if(days !== 'NaN' && days > 0){
                $('#no_of_days').val(days);
            } else {
                $('#no_of_days').val('');
            }
        } else if (duration === 'FN'){
            $('#end_date').prop('readonly', true);
            $('#end_date').val(startDate);
            $('#no_of_days').val(0.5);
        } else if (duration === 'AN'){
            $('#end_date').prop('readonly', true);
            $('#end_date').val(startDate);
            $('#no_of_days').val(0.5);
        }
    }

    function getEmployeeLeaveCount(){
        let id = $('#userSelect2').val();
        if (id === 'undefined' || id === null || id === "") {
            $('#availableCL').val(0);
            $('#availableSL').val(0);
            $('#availablePL').val(0);
            alert("Select Employee..");
        } else {
            $.ajax({
                type: "GET",
                url: '{{ url('leave/count/get/ajax') }}/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {
                        var leaveCount = response.leaveCount;
                        $('#availableCL').val(leaveCount.cl);
                        $('#availableSL').val(leaveCount.sl);
                        $('#availablePL').val(leaveCount.pl);

                        if(leaveCount.cl=='0.0' && leaveCount.sl=='0.0' && leaveCount.pl=='0.0'){
                             $("#msg_leave").html('Leave not available. if you take leave, it will be considered a loss of pay');
                        }else{
                            $("#msg_leave").html('');
                        }

                    } else if (response.status === 'fail') {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'Employee data Not Found!...',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function (error) {
                    console.log(error);
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'Something went wrong!, Try Again...',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        }
    }
</script>
@endsection
