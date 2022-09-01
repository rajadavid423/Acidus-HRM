@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">
                <div class="container-fluid">
                    {{--shift title--}}
                    <div class="titles d-flex justify-content-between">
                        <div class="mr-auto"><h5>Leave</h5></div>
                        @can('Leave Apply')
                        <a href="{{ route('leave.create') }}" type="button" class="btn btn-shift-primary btn-sm px-4">
                            Apply Leave
                        </a>
                        @endcan
                    </div>
                </div>
                <div class="container-fluid my-3">
                    {{--shift title--}}
                    <div class="titles d-flex justify-content-between">
                        {{--                        <div class="mr-auto"><p>Payment Info for June 2022 :</p></div>--}}
                        <div class="mx-4"></div>
                        <div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table text-center border rounded" id="list_table">
                            <thead class="thead-light">
                            <tr>
                                <th>S.No</th>
                                <th>Employee Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Duration</th>
                                <th>No Of Days</th>
                                <th>Leave Type</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>View</th>
                                <th>Delete</th>
                                <th>Approval</th>
                            </tr>
                            </thead>
                            <tbody class="small">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #leavetype, #leaveduration, span.select2.select2-container.select2-container--default {
            display: block !important;
        }
    </style>

@endsection
@section('script')
    <script>

        $(function () {
            $('#list_table').DataTable({
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("leave.index") }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'user_id'},
                    {data: 'start_date'},
                    {data: 'end_date'},
                    {data: 'duration'},
                    {data: 'no_of_days'},
                    {data: 'leave_type'},
                    {data: 'reason'},
                    {data: 'status'},
                    {data: 'view', orderable: false},
                    {data: 'delete', orderable: false},
                    {data: 'approval', orderable: false},
                ]
            });
        });

    </script>
@endsection

@can('Leave Approval')
{{--<!--For add Modal -->--}}
<input type="hidden" id="leaveRejectOpenButton" aria-hidden="true" data-toggle="modal" data-target="#rejectModel">
{{--<!--For  Reject -->--}}
<div class="modal" id="rejectModel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header shiftmoderheader">
                <h6 class="modal-title w-100 text-center ">Reject Reason</h6>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-4">
                <div class="form-group row">
                    <div class="col-sm-12">
                                <textarea
                                    class="form-control list-group-item-shift-secondary"
                                    name="reject_reason" placeholder="Enter Leave Reject Reason"
                                    id="reject_reason" required>{{ old('reject_reason')}}</textarea>
                        <span id="description_error_message"></span>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer Shiftmodelfooter" id="leaveRejectSubmitDiv">
                <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal"
                         id="closeLeaveReasonModel">
                    Close
                </button>
                <button>Save</button>
            </div>
            {{--                </form>--}}
        </div>
    </div>
</div>


{{--<!--For Reject Modal -->--}}
<script>
    function rejectModel(id){
        $('#reject_reason').val('');
        $('#leaveRejectSubmitDiv button:last').remove()
        $('#leaveRejectSubmitDiv').append('<button type="submit" class="btn btn-shift-primary btn-sm px-4" onclick="leaveRejectSubmit(' +id + ')">Submit</button>')
        $('#leaveRejectOpenButton').trigger('click');
    }


    function leaveRejectSubmit(id){

        let reject_reason = $('#reject_reason').val();

        if (reject_reason === 'undefined' || reject_reason === null || reject_reason === "") {
            let text1 = "Enter Leave Reason to Submit !..";
            if (confirm(text1) == false) {
                $('#closeLeaveReasonModel').trigger('click');
            }
        } else {
            $.ajax({
                type: "get",
                url: '{{ url('leave/reject') }}/' + id,
                data: {
                    reject_reason: reject_reason,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    console.log(response);
                    if (response.status === 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Leave Request Rejected Successfully...',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#list_table').DataTable().ajax.reload();

                        $('#closeLeaveReasonModel').trigger('click');

                        $("#reject_reason").val('');

                    } else if (response.status === 'fail') {
                        Swal.fire({
                            position: 'center',
                            icon: 'warning',
                            title: 'Leave Request Rejection Failed!...',
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
@endcan
