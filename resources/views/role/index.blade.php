@extends('layouts.layout')

@section('content')
    @include('common_script.alert_script')
    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">

                {{--shift title--}}
                <div class="container-fluid">
                    <div class="titles d-flex justify-content-between">
                        <h6>Roles</h6>

                        <!-- Button trigger modal -->
                        <a class="btn btn-sm btnPrimaryCustomizeBlue btn-primary add-btn" href="{{ route('role.create') }}">+ Add Roles</a>
                    </div>
                </div>
                <div class="container-fluid mt-4">
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="table text-center border rounded" id="list_table">
                                <thead class="thead-light">
                                <tr>
                                    <th><b>S.No</b></th>
                                    <th><b>Roles</b></th>
                                    <th><b>View</b></th>
                                    <th><b>Edit</b></th>
                                    <th><b>Delete</b></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
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
                            url: '{{ url("/roles") }}',
                            type: 'GET'
                        },
                        columns: [
                            {data: 'DT_RowIndex'},
                            {data: 'name'},
                            {data: 'view', orderable: false},
                            {data: 'edit', orderable: false},
                            {data: 'delete', orderable: false},
                        ]
                    });
                });
            </script>
@endsection

