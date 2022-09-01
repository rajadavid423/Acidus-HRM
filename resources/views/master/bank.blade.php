@extends('layouts.layout')
@section('content')
    @include('common_script.alert_script')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="container-fluid">
                    <div class="titles d-flex justify-content-between">
                        <h6>Banks</h6>
                        <a class="btn btn-sm btnPrimaryCustomizeBlue btn-primary add-btn" data-toggle="modal"
                           data-target="#addbranch" onclick="emptyInput()">+ Add Bank</a>
                    </div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table text-center border rounded" id="list_table">
                                <thead class="thead-light">
                                <tr>
                                    <th><b>S.No</b></th>
                                    <th><b>Bank</b></th>
                                    <th><b>Action</b></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<!--For add Modal -->--}}
        <div class="modal" id="addbranch">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header shiftmoderheader">
                        <h6 class="modal-title w-100 text-center ">Add Bank</h6>
                        {{--  <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body p-4">
                        <form>
                            <div class="form-group row">
                                <label for="inputPassword" class="col-sm-4">Bank Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control list-group-item-shift-secondary" name="name"
                                           id="name">
                                    <span id="name_error_message"></span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer Shiftmodelfooter">
                        <button type="button" class="btn btn-shift-primary btn-sm px-4" onclick="formSubmit()">Save</button>
                        <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal" id="closeModel" onclick="emptyInput()">Close
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal" id="updateBranch">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header shiftmoderheader">
                        <h6 class="modal-title w-100 text-center ">Edit Bank</h6>
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
                            <label for="inputPassword" class="col-sm-4">Bank Name</label>
                            <div class="col-sm-8">
                                <input type="text"
                                       class="form-control list-group-item-shift-secondary @error('name') is-invalid @enderror"
                                       name="name"
                                       id="edit_name" value="{{ old('name')}}" required>
                                <span id="edit_name_error_message"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer Shiftmodelfooter">
                        <button type="submit" class="btn btn-shift-primary btn-sm px-4" onclick="formUpdate()">Save
                        </button>
                        <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal"
                                id="closeModelEdit" onclick="emptyInput();">
                            Close
                        </button>
                    </div>
                    {{--                </form>--}}
                </div>
            </div>
        </div>

        @endsection

        @section('script')
        @include('common_script.delete_script')
        <script>
            $(function () {
                $('#list_table').DataTable({
                    "columnDefs": [
                        {"className": "dt-center", "targets": "_all"}
                    ],
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/bank") }}',
                        type: 'GET'
                    },
                    columns: [
                        {data: 'DT_RowIndex'},
                        {data: 'name'},
                        {data: 'action', orderable: false},
                    ]
                });
            });

            // Empty Input
            function emptyInput() {

                    $("#name").val('');
                    $("#name_error_message").text('');
                    $("#edit_name_error_message").text('');
                    $("#edit_id").val('');
                    $("#edit_name").val('');
            }

            //Save Data
            function formSubmit() {
                var bank_name = $('#name').val();

                if (bank_name === 'undefined' || bank_name === null || bank_name === "") {
                    let text1 = "Enter Name!..";
                    if (confirm(text1) == false) {
                        $('#closeModel').trigger('click');
                    }
                } else {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('bank.store') }}',
                        data: {
                            name: bank_name,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.message === 'Success') {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'Bank Name Saved Successfully',
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

                            if ((error.status === 422) && (error.responseJSON.errors.name[0] === 'The name has already been taken.')) {

                                $('#name_error_message').text(error.responseJSON.errors.name[0]).css("color", "red");

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
                    var name = $('#edit_name').val();
                    if (name === 'undefined' || name === null || name === "") {
                        let text1 = "Enter Name!..";
                        if (confirm(text1) == false) {
                            $('#closeModelEdit').trigger('click');
                        }
                     }  else {
                        $.ajax({
                            type: "PUT",
                            url: '{{ route('bank.update') }}',
                            data: {
                                id: id,
                                name: name,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                console.log(response);
                                if (response.message === 'Success') {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Bank Name Updated Successfully',
                                        showConfirmButton: false,
                                        timer: 2000,
                                        color:'black',
                                        background:'white',
                                    })
                                    $('#closeModelEdit').trigger('click');
                                    emptyInput();
                                    $('#list_table').DataTable().ajax.reload();
                                }
                            },
                            error: function (error, jqXHR, textStatus) {
                                console.log(error);
                                if ((error.status === 422) && (error.responseJSON.errors.name[0] === 'The name has already been taken.')) {
                                    $('#edit_name_error_message').text(error.responseJSON.errors.name[0]).css("color", "red");
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
                        url: '{{url('bank/edit')}}/' + id,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            var editModel = response.editModel;
                            $('#edit_id').val(editModel.id);
                            $('#edit_name').val(editModel.name);
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
        </script>
@endsection
