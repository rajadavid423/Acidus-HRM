@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">

                {{--shift title--}}
                <div class="container-fluid">
                    <div class="titles d-flex justify-content-between">
                        <h6>Client Management</h6>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-shift-primary btn-sm px-4" data-toggle="modal"
                                data-target="#addClient" onclick="emptyInput()">
                            Add Client
                        </button>
                    </div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="table-responsive">
                            <table class="table text-center border rounded" id="list_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>Client Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                    </div>
                </div>
            </div>
        </div>

        {{--<!--For add Modal -->--}}
        <div class="modal" id="addClient">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                {{--                <form method="POST" action="{{route('client.store')}}">--}}
                {{--                {{csrf_field()}}--}}
                {{--                @csrf--}}
                <!-- Modal Header -->
                    <div class="modal-header shiftmoderheader">
                        <h6 class="modal-title w-100 text-center ">Add Client</h6>
                        {{--                <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body p-4">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Client Name</label>
                            <div class="col-sm-8">
                                <input type="text"
                                       class="form-control list-group-item-shift-secondary"
                                       name="client_name"
                                       id="client_name" value="{{ old('client_name')}}" required>
                                <span id="client_error_message"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Description</label>
                            <div class="col-sm-8">
                                <textarea
                                    class="form-control list-group-item-shift-secondary"
                                    name="description"
                                    id="description" required>{{ old('description')}}</textarea>
                                <span id="description_error_message"></span>
                            </div>
                        </div>


                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer Shiftmodelfooter">

                        <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal"
                                id="closeModel" onclick="emptyInput();">
                            Close
                        </button>
                        <button type="submit" class="btn btn-shift-primary btn-sm px-4" onclick="formSubmit()">Save
                        </button>

                    </div>
                    {{--                </form>--}}
                </div>
            </div>
        </div>

        {{--<!--For update Modal -->--}}
        <div class="modal" id="updateClient">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                {{--                <form method="POST" action="{{route('client.update')}}">--}}
                {{--                @csrf--}}
                {{--                @method('PUT')--}}
                <!-- Modal Header -->
                    <div class="modal-header shiftmoderheader">
                        <h6 class="modal-title w-100 text-center ">Edit Client</h6>
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
                            <label for="inputPassword" class="col-sm-4">Client Name</label>
                            <div class="col-sm-8">
                                <input type="text"
                                       class="form-control list-group-item-shift-secondary @error('client_name') is-invalid @enderror"
                                       name="client_name"
                                       id="edit_client_name" value="{{ old('client_name')}}" required>
                                <span id="edit_client_error_message"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Description</label>
                            <div class="col-sm-8">
                                <textarea
                                    class="form-control list-group-item-shift-secondary @error('description') is-invalid @enderror"
                                    name="description"
                                    id="edit_description" required>{{ old('description')}}</textarea>
                                <span id="description_error_message"></span>
                            </div>
                        </div>


                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer Shiftmodelfooter">

                        <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal"
                                id="closeModelEdit" onclick="emptyInput();">
                            Close
                        </button>
                        <button type="submit" class="btn btn-shift-primary btn-sm px-4" onclick="formUpdate()">Save
                        </button>

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
                            url: '{{ route("client.index") }}',
                            type: 'GET'
                        },
                        columns: [
                            {data: 'DT_RowIndex'},
                            {data: 'client_name'},
                            {data: 'description'},
                            {data: 'action', orderable: false},

                        ]
                    });
                });
            </script>
            <script>
                function emptyInput() {
                    $("#client_name").val('');
                    $("#description").val('');
                    $("#client_error_message").text('');
                    $("#description_error_message").text('');
                    $("#edit_client_error_message").text('');
                    $("#edit_id").val('');
                    $("#edit_client_name").val('');
                    $("#edit_description").val('');

                }

                function formSubmit() {
                    var client_name = $('#client_name').val();
                    var description = $('#description').val();
                    if (client_name === 'undefined' || client_name === null || client_name === "") {
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
                            url: '{{ route('client.store') }}',
                            data: {
                                client_name: client_name,
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
                                        title: 'Client name Saved Successfully',
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
                                if ((error.status === 422) && (error.responseJSON.errors.client_name[0] === 'The client name has already been taken.')) {
                                    $('#client_error_message').text(error.responseJSON.errors.client_name[0]).css("color", "red");
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
                    var client_name = $('#edit_client_name').val();
                    var description = $('#edit_description').val();
                    if (client_name === 'undefined' || client_name === null || client_name === "") {
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
                            url: '{{ route('client.update') }}',
                            data: {
                                id: id,
                                client_name: client_name,
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
                                        title: 'Client name Updated Successfully',
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
                                if ((error.status === 422) && (error.responseJSON.errors.client_name[0] === 'The client name has already been taken.')) {
                                    $('#edit_client_error_message').text(error.responseJSON.errors.client_name[0]).css("color", "red");
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
                        url: '{{url('client/edit')}}/' + id,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            var editModel = response.editModel;
                            $('#edit_id').val(editModel.id);
                            $('#edit_client_name').val(editModel.client_name);
                            $('#edit_description').val(editModel.description);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            </script>
@endsection
