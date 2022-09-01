@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">

                {{--shift title--}}
                <div class="container-fluid">
                    <div class="titles d-flex justify-content-between">
                        <h6>Team Management</h6>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-shift-primary btn-sm px-4" data-toggle="modal"
                                data-target="#addTeam" onclick="emptyInput()">
                            Add Team
                        </button>
                    </div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="table-responsive">
                            <table class="table text-center border rounded" id="list_table">
                                <thead class="thead-light">
                                <tr>
                                    <th>S.No</th>
                                    <th>Team Name</th>
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
        <div class="modal" id="addTeam">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                {{--                <form method="POST" action="{{route('team.store')}}">--}}
                {{--                {{csrf_field()}}--}}
                {{--                @csrf--}}
                <!-- Modal Header -->
                    <div class="modal-header shiftmoderheader">
                        <h6 class="modal-title w-100 text-center ">Add Team</h6>
                        {{--                <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body p-4">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Team Name</label>
                            <div class="col-sm-8">
                                <input type="text"
                                       class="form-control list-group-item-shift-secondary @error('team_name') is-invalid @enderror"
                                       name="team_name"
                                       id="team_name" value="{{ old('team_name')}}" required>
                                <span id="team_error_message"></span>
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

                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Responsible Person</label>
                            <div class="col-sm-8">
                                <select multiple="multiple" class=" form-control @error('responsible_person') is-invalid @enderror" name="responsible_person" id="responsible_person" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id}}"> {{ $user->name }} </option>
                                    @endforeach
                                </select>
                                <span id="responsible_person_error_message"></span>
                            </div>
                        </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer Shiftmodelfooter">

                        <button type="button" class="btn btn-outline-shift-primary btn-sm px-4" data-dismiss="modal" id="closeModel" onclick="emptyInput();">
                            Close
                        </button>
                        <button type="submit" class="btn btn-shift-primary btn-sm px-4" onclick="formSubmit()">Save </button>
                    </div>
                    {{-- </form>--}}
                </div>
            </div>
        </div>

        {{--<!--For update Modal -->--}}
        <div class="modal" id="updateTeam">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                {{--                <form method="POST" action="{{route('team.update')}}">--}}
                {{--                @csrf--}}
                {{--                @method('PUT')--}}
                <!-- Modal Header -->
                    <div class="modal-header shiftmoderheader">
                        <h6 class="modal-title w-100 text-center ">Edit Team</h6>
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
                            <label for="inputPassword" class="col-sm-4">Team Name</label>
                            <div class="col-sm-8">
                                <input type="text"
                                       class="form-control list-group-item-shift-secondary @error('team_name') is-invalid @enderror"
                                       name="team_name"
                                       id="edit_team_name" value="{{ old('team_name')}}" required>
                                <span id="edit_team_error_message"></span>
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
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-4">Responsible Person</label>
                            <div class="col-sm-8">
                                <select multiple="multiple" class=" form-control @error('responsible_person') is-invalid @enderror" name="responsible_person" id="responsible_person_edit" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"> {{ $user->name }} </option>
                                    @endforeach
                                </select>
                                <span id="responsible_person_error_message"></span>
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
                    {{-- </form>--}}
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
                            url: '{{ route("team.index") }}',
                            type: 'GET'
                        },
                        columns: [
                            {data: 'DT_RowIndex'},
                            {data: 'team_name'},
                            {data: 'description'},
                            {data: 'action', orderable: false},
                        ]
                    });
                });
            </script>
            <script>
                function emptyInput() {
                    $("#team_name").val('');
                    $("#description").val('');
                    $("#team_error_message").text('');
                    $("#description_error_message").text('');
                    $("#edit_team_error_message").text('');
                    $("#edit_id").val('');
                    $("#edit_team_name").val('');
                    $("#edit_description").val('');
                }

                function formSubmit() {
                    var team_name = $('#team_name').val();
                    var description = $('#description').val();
                    var responsible_person = $('#responsible_person').val();

                    console.log(responsible_person);
                    console.log(responsible_person.length);

                    if (team_name === 'undefined' || team_name === null || team_name === "") {
                        let text1 = "Enter Name!..";
                        if (confirm(text1) == false) {
                            $('#closeModel').trigger('click');
                        }
                    } else if (description === 'undefined' || description === null || description === "") {
                        let text2 = "Enter description";
                        if (confirm(text2) == false) {
                            $('#closeModel').trigger('click');
                        }
                    }else if(responsible_person==='undefined' || responsible_person=== null || responsible_person.length==0){
                        let text3 = "Select Responsible person";
                        if (confirm(text3) == false) {
                            $('#closeModel').trigger('click');
                        }
                    } else {
                        $.ajax({
                            type: "POST",
                            url: '{{ route('team.store') }}',
                            data: {
                                team_name: team_name,
                                description: description,
                                responsible_person : responsible_person,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                //console.log(response);
                                if (response.message === 'Success') {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-right',
                                        icon: 'success',
                                        title: 'Team name Saved Successfully',
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
                                if ((error.status === 422) && (error.responseJSON.errors.team_name[0] === 'The team name has already been taken.')) {
                                    $('#team_error_message').text(error.responseJSON.errors.team_name[0]).css("color", "red");
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
                    var team_name = $('#edit_team_name').val();
                    var description = $('#edit_description').val();
                    var responsible_person_edit = $('#responsible_person_edit').val();
                    if (team_name === 'undefined' || team_name === null || team_name === "") {
                        let text1 = "Enter Name!..";
                        if (confirm(text1) == false) {
                            $('#closeModelEdit').trigger('click');
                        }
                    } else if (description === 'undefined' || description === null || description === "") {
                        let text2 = "Enter description";
                        if (confirm(text2) == false) {
                            $('#closeModelEdit').trigger('click');
                        }
                    }else if(responsible_person_edit==='undefined' || responsible_person_edit=== null || responsible_person_edit.length==0){
                        let text3 = "Select Responsible person";
                        if (confirm(text3) == false) {
                            $('#closeModelEdit').trigger('click');
                        }
                    } else {
                        $.ajax({
                            type: "PUT",
                            url: '{{ route('team.update') }}',
                            data: {
                                id: id,
                                team_name: team_name,
                                description: description,
                                responsible_person : responsible_person_edit,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                console.log(response);
                                if (response.message === 'Success') {
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-right',
                                        icon: 'success',
                                        title: 'Team name Updated Successfully',
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
                                if ((error.status === 422) && (error.responseJSON.errors.team_name[0] === 'The team name has already been taken.')) {
                                    $('#edit_team_error_message').text(error.responseJSON.errors.team_name[0]).css("color", "red");
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
                        url: '{{ url('team/edit')}}/' + id,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            var editModel = response.editModel;
                            $('#edit_id').val(editModel.id);
                            $('#edit_team_name').val(editModel.team_name);
                            $('#edit_description').val(editModel.description);
                            $('#responsible_person_edit').val(editModel.responsible_person).change();

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }

                $( document ).ready(function() {
                      $("#responsible_person").select2({
                        placeholder: "Select a Responsible",
                        allowClear: true,
                        width: '100%',
                    });

                    $("#responsible_person_edit").select2({
                        placeholder: "Select a Responsible",
                        allowClear: true,
                        width: '100%',
                    });
                });

            </script>
@endsection
