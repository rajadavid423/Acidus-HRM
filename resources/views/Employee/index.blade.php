@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">
                <div class="container-fluid">
                    {{--shift title--}}
                    <div class="titles d-flex justify-content-between">
                        <div class="mr-auto"><h6>Employee List</h6></div>
                        @can('View Employee')
                        <a href="{{route('Employee.export') }}" type="button" class="btn btn-shift-primary btn-sm px-4">
                            Export Employee
                        </a>
                        @endcan&nbsp;
                        @can('Create Employee')
                        <a href="{{route('Employee.create') }}" type="button" class="btn btn-shift-primary btn-sm px-4">
                            Add Employee
                        </a>
                        @endcan
                    </div>
                </div>

                <div class="container-fluid mt-3">
                    <div class="table-responsive">
                        <table class="table text-center border rounded" id="list_table">
                            <thead class="thead-light">
                            <tr>
                                <th>S.No</th>
                                <th>Employee&nbsp;Name</th>
                                <th>Gender</th>
                                <th>Emp&nbsp;ID</th>
                                <th>Salary</th>
                                <th>Designation</th>
                                <th>Shift</th>
                                <th>Team</th>
                                <th>Phone&nbsp;No.</th>
                                <th>Email&nbsp;ID</th>
                                <th>Action</th>
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
                    url: '{{ route("Employee.index") }}',
                    type: 'GET'
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'name'},
                    {data: 'gender'},
                    {data: 'employee_id'},
                    {data: 'salary'},
                    {data: 'designation_name'},
                    {data: 'shift_name'},
                    {data: 'team_name'},
                    {data: 'phone_number'},
                    {data: 'email'},
                    {data: 'action', orderable: false},

                ]
            });
        });
    </script>
@endsection
