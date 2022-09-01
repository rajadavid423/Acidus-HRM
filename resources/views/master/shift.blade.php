@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">

                {{--shift title--}}
                <div class="titles d-flex justify-content-between">
                    <h6>Shift Management</h6>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-shift-primary btn-sm px-4" data-toggle="modal"
                            data-target="#addshift" onclick="emptyInput()">
                        Add Shift
                    </button>
                </div>

                {{--shift table--}}
                <div class="Shift_table table-responsive mt-4">
                    <table class="table text-center border rounded" id="list_table">
                        <thead class="thead-light Shift_thead">
                        <tr>
                            <th scope="col">S.no</th>
                            <th scope="col">Shift Name</th>
                            <th scope="col">Shift Timing</th>
                            <th scope="col">End Timing</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{--<!--For add Modal -->--}}
    <div class="modal" id="addshift">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header shiftmoderheader">
                    <h6 class="modal-title w-100 text-center ">Add Shift</h6>
                    {{--                <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                </div>

                <!-- Modal body -->
                <div class="modal-body p-4">
                    <form>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Shift Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control list-group-item-shift-secondary" name="shift_name"
                                       id="shift_name">
                                <span id="shift_name_error_message"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Shift Start Time</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control list-group-item-shift-secondary" name="start_time"
                                       id="start_time">
                                <span id="start_time_error_message"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Shift End Time</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control list-group-item-shift-secondary" name="end_time"
                                       id="end_time">
                                <span id="end_time_error_message"></span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer Shiftmodelfooter">

                    <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal" id="closeModel" onclick="emptyInput()">Close
                    </button>
                    <button type="button" class="btn btn-shift-primary btn-sm px-4" onclick="formSubmit()">Save</button>

                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="updateShift">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header shiftmoderheader">
                    <h6 class="modal-title w-100 text-center ">Edit Shift</h6>
                    {{--                <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                </div>

                <!-- Modal body -->
                <div class="modal-body p-4">
                    <form>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Shift Name</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control list-group-item-shift-secondary d-none"
                                       name="id"
                                       id="edit_id">
                                <input type="text" class="form-control list-group-item-shift-secondary" name="shift_name"
                                       id="edit_shift_name">
                                <span id="edit_shift_name_error_message"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Shift Start Time</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control list-group-item-shift-secondary" name="start_time"
                                       id="edit_start_time">
                                <span id="start_time_error_message"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Shift End Time</label>
                            <div class="col-sm-8">
                                <input type="time" class="form-control list-group-item-shift-secondary" name="end_time"
                                       id="edit_end_time">
                                <span id="end_time_error_message"></span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer Shiftmodelfooter">

                    <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal" onclick="emptyInput()" id="editcloseModel">Close
                    </button>
                    <button type="button" class="btn btn-shift-primary btn-sm px-4" onclick="formUpdate()">Save</button>
                </div>

            </div>
        </div>
    </div>
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
                    url: '{{ route("shift.index") }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'shift_name'},
                    {data: 'start_time'},
                    {data: 'end_time'},
                    {data: 'action', orderable: false},

                ]
            });
        });
    </script>
    <script>
        function emptyInput() {
            $("#shift_name").val('');
            $("#start_time").val('');
            $("#end_time").val('');
            $("#shift_name_error_message").text('');
            $("#start_time_error_message").text('');
            $("#end_time_error_message").text('');
            $("#edit_shift_name_error_message").text('');
            $("#edit_id").val('');
            $("#edit_shift_name").val('');
            $("#edit_start_time").val('');
            $("#edit_end_time").val('');
        }

        function formSubmit() {
            var shift_name = $('#shift_name').val();
            var start_time = $('#start_time').val();
            var end_time = $('#end_time').val();

            if (shift_name === 'undefined' || shift_name === null || shift_name === "") {
                let text1 = "Enter Name!..";
                if (confirm(text1) == false) {
                    $('#closeModel').trigger('click');
                }
            } else if (start_time === 'undefined' || start_time === null || start_time === "") {
                let text2 = "Enter start time";
                if (confirm(text2) == false) {
                    $('#closeModel').trigger('click');
                }
            } else if (end_time === 'undefined' || end_time === null || end_time === "") {
                let text3 = "Enter end time";
                if (confirm(text3) == false) {
                    $('#closeModel').trigger('click');
                }
            } else {
                $.ajax({
                    type: "POST",
                    url: '{{ route('shift.store') }}',
                    data: {
                        shift_name: shift_name,
                        start_time: start_time,
                        end_time: end_time,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.message === 'Success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-right',
                                icon: 'success',
                                title: 'Shift name Saved Successfully',
                                showConfirmButton: false,
                                timer: 2000,
                                color:'black',
                                background:'white',
                            })
                            $('#closeModel').trigger('click');
                            emptyInput();
                            $('#list_table').DataTable().ajax.reload();
                        }
                    },
                    error: function (error, jqXHR, textStatus) {
                        console.log(error);
                        if ((error.status === 422) && (error.responseJSON.errors.shift_name[0] === 'The shift name has already been taken.')) {
                            $('#shift_name_error_message').text(error.responseJSON.errors.shift_name[0]).css("color", "red");
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: 'Something went wrong!, Try Again...',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }
        }
    </script>
    <script>
        function formUpdate() {
            var id = $('#edit_id').val();
            var shift_name = $('#edit_shift_name').val();
            var start_time = $('#edit_start_time').val();
            var end_time = $('#edit_end_time').val();
            if (shift_name === 'undefined' || shift_name === null || shift_name === "") {
                let text1 = "Enter Name!..";
                if (confirm(text1) == false) {
                    $('#closeModelEdit').trigger('click');
                }
            } else if (start_time === 'undefined' || start_time === null || start_time === "") {
                let text2 = "Enter start time";
                if (confirm(text2) == false) {
                    $('#closeModelEdit').trigger('click');
                }
            } else if (end_time === 'undefined' || end_time === null || end_time === "") {
                let text3 = "Enter end time";
                if (confirm(text3) == false) {
                    $('#closeModelEdit').trigger('click');
                }
            } else {
                $.ajax({
                    type: "PUT",
                    url: '{{ route('shift.update') }}',
                    data: {
                        id: id,
                        shift_name: shift_name,
                        start_time: start_time,
                        end_time: end_time,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.message === 'Success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-right',
                                icon: 'success',
                                title: 'shift name Updated Successfully',
                                showConfirmButton: false,
                                timer: 2000,
                                color:'black',
                                background:'white',
                            })
                            $('#editcloseModel').trigger('click');
                            emptyInput();
                            $('#list_table').DataTable().ajax.reload();
                        }
                    },
                    error: function (error, jqXHR, textStatus) {
                        console.log(error);
                        if ((error.status === 422) && (error.responseJSON.errors.shift_name[0] === 'The shift name has already been taken.')) {
                            $('#edit_shift_name_error_message').text(error.responseJSON.errors.shift_name[0]).css("color", "red");
                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'warning',
                                title: 'Something went wrong!, Try Again...',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }
        }
    </script>
    <script>
        function getModelValue(id) {
            $.ajax({
                type: "GET",
                url: '{{url('shift/edit')}}/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    var editModel = response.editModel;
                    $('#edit_id').val(editModel.id);
                    $('#edit_shift_name').val(editModel.shift_name);
                    $('#edit_start_time').val(editModel.start_time);
                    $('#edit_end_time').val(editModel.end_time);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
