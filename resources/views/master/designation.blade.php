@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">
                <div class="container-fluid">
                    {{--shift title--}}
                    <div class="titles d-flex justify-content-between">
                        <h6>Designation Management</h6>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-shift-primary btn-sm px-4" data-toggle="modal"
                                data-target="#addDesignation" onclick="emptyInput()">
                            Add Designation
                        </button>
                    </div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="table-responsive">
                        <table class="table text-center border rounded" id="list_table">
                            <thead class="thead-light">
                            <tr>
                                <th>S.No</th>
                                <th>Designation</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--<!--For add Modal -->--}}
    <div class="modal" id="addDesignation">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            {{--                <form method="POST" action="{{route('designation.store')}}">--}}
            {{--                {{csrf_field()}}--}}
            <!-- Modal Header -->
                <div class="modal-header shiftmoderheader">
                    <h6 class="modal-title w-100 text-center ">Add Designation</h6>
                    {{--                <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                </div>

                <!-- Modal body -->
                <div class="modal-body p-4">
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-4">Designation Name</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   class="form-control list-group-item-shift-secondary @error('designation_name') is-invalid @enderror"
                                   name="designation_name"
                                   id="designation_name" value="{{ old('designation_name')}}" required>
                            <span id="client_error_message"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-4">Description</label>
                        <div class="col-sm-8">
                                <textarea
                                    class="form-control list-group-item-shift-secondary @error('description') is-invalid @enderror"
                                    name="description"
                                    id="description" required>{{ old('description')}}</textarea>
                            <span id="description_error_message"></span>
                        </div>
                    </div>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer Shiftmodelfooter">

                    <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal"
                            id="closeModel"onclick="emptyInput();">
                        Close
                    </button>
                    <button type="submit" class="btn btn-shift-primary btn-sm px-4" onclick="formSubmit()">Save</button>

                </div>
            </div>
        </div>
    </div>

    {{--<!--For update Modal -->--}}
    <div class="modal" id="updateDesignation">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            {{--                <form method="POST" action="{{route('designation.update')}}">--}}
            {{--                @csrf--}}
            {{--                @method('PUT')--}}
            <!-- Modal Header -->
                <div class="modal-header shiftmoderheader">
                    <h6 class="modal-title w-100 text-center ">Edit Designation</h6>
                    {{--                <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                </div>
                <!-- Modal body -->
                <div class="modal-body p-4">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <input type="text" class="form-control list-group-item-shift-secondary d-none"
                                   name="id"
                                   id="edit_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-4">Designation Name</label>
                        <div class="col-sm-8">
                            <input type="text"
                                   class="form-control list-group-item-shift-secondary @error('designation_name') is-invalid @enderror"
                                   name="designation_name"
                                   id="edit_designation_name" value="{{ old('designation_name')}}" required>
                            <span id="edit_designation_error_message"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-4">Description</label>
                        <div class="col-sm-8">
                                <textarea
                                    class="form-control list-group-item-shift-secondary @error('description') is-invalid @enderror"
                                    name="description"
                                    id="edit_description" required>{{ old('description')}}</textarea>
                            <span id="edit_description_error_message"></span>
                        </div>
                    </div>


                </div>

                <!-- Modal footer -->
                <div class="modal-footer Shiftmodelfooter">

                    <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal"
                            id="closeModelEdit" onclick="emptyInput();">
                        Close
                    </button>
                    <button type="submit" class="btn btn-shift-primary btn-sm px-4" onclick="formUpdate()">Save</button>

                </div>
                {{--                </form>--}}
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
                    url: '{{ route("designation.index") }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'designation_name'},
                    {data: 'description'},
                    {data: 'action', orderable: false},

                ]
            });
        });
    </script>
    <script>
        function emptyInput() {
            $("#designation_name").val('');
            $("#description").val('');
            $("#designation_error_message").text('');
            $("#description_error_message").text('');
            $("#edit_designation_error_message").text('');
            $("#edit_id").val('');
            $("#edit_designation_name").val('');
            $("#edit_description").val('');
        }

        function formSubmit() {
            var designation_name = $('#designation_name').val();
            var description = $('#description').val();
            if (designation_name === 'undefined' || designation_name === null || designation_name === "") {
                let text1 = "Enter Name!..";
                if (confirm(text1) == false) {
                    $('#closeModel').trigger('click');
                }
            } else if (description === 'undefined' || description === null || description === "") {
                let text2 = "Enter description";
                if (confirm(text2) == false) {
                    $('#closeModel').trigger('click');
                }
            } else {
                $.ajax({
                    type: "POST",
                    url: '{{ route('designation.store') }}',
                    data: {
                        designation_name: designation_name,
                        description: description,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.message === 'Success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-right',
                                icon: 'success',
                                title: 'Designation name Saved Successfully',
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
                        if ((error.status === 422) && (error.responseJSON.errors.designation_name[0] === 'The designation name has already been taken.')) {
                            $('#designation_error_message').text(error.responseJSON.errors.designation_name[0]).css("color", "red");
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
            var designation_name = $('#edit_designation_name').val();
            var description = $('#edit_description').val();
            if (designation_name === 'undefined' || designation_name === null || designation_name === "") {
                let text1 = "Enter Name!..";
                if (confirm(text1) == false) {
                    $('#closeModelEdit').trigger('click');
                }
            } else if (description === 'undefined' || description === null || description === "") {
                let text2 = "Enter description";
                if (confirm(text2) == false) {
                    $('#closeModelEdit').trigger('click');
                }
            } else {
                $.ajax({
                    type: "PUT",
                    url: '{{ route('designation.update') }}',
                    data: {
                        id: id,
                        designation_name: designation_name,
                        description: description,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.message === 'Success') {
                            Swal.fire({
                                toast: true,
                                position: 'top-right',
                                icon: 'success',
                                title: 'Designation name Updated Successfully',
                                showConfirmButton: false,
                                timer: 2000,
                                background: '#0F75BD',
                            })
                            $('#closeModelEdit').trigger('click');
                            emptyInput();
                            $('#list_table').DataTable().ajax.reload();
                        }
                    },
                    error: function (error, jqXHR, textStatus) {
                        console.log(error);
                        if ((error.status === 422) && (error.responseJSON.errors.designation_name[0] === 'The designation name has already been taken.')) {
                            $('#edit_designation_error_message').text(error.responseJSON.errors.designation_name[0]).css("color", "red");
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
                url: '{{url('designation/edit')}}/' + id,
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    var editModel = response.editModel;
                    $('#edit_id').val(editModel.id);
                    $('#edit_designation_name').val(editModel.designation_name);
                    $('#edit_description').val(editModel.description);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    </script>
@endsection
