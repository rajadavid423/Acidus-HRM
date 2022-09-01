@extends('layouts.layout')

@section('content')
    <div class="loading-screen" id="loading-screen">
        <div class="spinner-container">
            <span class="first">
                <img src="{{asset('images/loader.png')}}">
            </span>
            <span class="bol"></span>
            <div class="spinner"></div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            {{--        shift start--}}
            <div class="col-md-12">
                <div class="container-fluid">
                    {{--shift title--}}
                    <div class="titles ">
                        <form action="{{ route('exportPayroll') }}" method="POST" >
                            @csrf
                        <div class="row">
                            <div class="col-lg-3 col-md-3">
                                <h5 class="mt-1">Payroll Management</h5>
                            </div>

                            <div class="col-lg-2 col-md-3">
                                <input type="month" id="monthYear" name="monthYear" required class="form-control form-control-sm mb-2" max="{{ (now()->format('d') >= 26) ? now()->format('Y-m') : now()->subMonth()->format('Y-m') }}"/>
                            </div>
                            <div class="col-lg-1 col-md-2">
                                <a id="filter" type="button" class="btn btn-shift-primary btn-sm px-4  mb-2">Filter</a>
                            </div>

                            <div class="col-lg-2 col-md-2 text-md-right">
                                @can('Generate Payslip')
                                    <a onclick="generatePayroll()" type="button"
                                       class="btn btn-shift-primary btn-sm px-4 mr-3 mb-2">
                                        Generate
                                    </a>
                                @endcan
                            </div>
                            <div class="col-lg-2 col-md-3 text-md-center">
                                @can('Send Mail')
                                    <a type="button" class="btn btn-shift-primary btn-sm px-4 mr-3 mb-2"
                                       onclick="sendPayrollEmail()">
                                        Send Email
                                    </a>
                                @endcan
                            </div>
                            <div class="col-lg-2 col-md-4">
                                @can('Export Payroll')
                                    <button type="submit" class="btn btn-shift-primary btn-sm px-4 mr-3 mb-2" >Export Payroll</button>
                                @endcan
                            </div>

                        </div>
                        </form>
                    </div>
                </div>
                <div class="container-fluid my-3">
                    {{--shift title--}}
                    <div class="titles d-flex justify-content-between">
                        <div class="mx-4"></div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table text-center border rounded" id="list_table">
                            <thead class="thead-light">
                            <tr>
                                <th>S.No</th>
                                <th>Employee</th>
                                <th>Employee ID</th>
                                <th>Pay Period</th>
                                <th>Gross Amount</th>
                                <th>Net Amount</th>
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

        $("#filter").on('click', function (e) {
            $('#list_table').DataTable().ajax.reload();
        });

        $(function () {
            $('#list_table').DataTable({
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("payroll.index") }}',
                    type: 'GET',
                    beforeSend: function () {
                        $('#loading-screen').css("visibility", "visible");
                    },
                    complete: function () {
                        $('#loading-screen').css("visibility", "hidden");
                    },
                    data: function (data) {
                        data.monthYear = $('#monthYear').val();
                    },
                },
                columns: [
                    {data: 'DT_RowIndex'},
                    {data: 'user_name'},
                    {data: 'employee_id'},
                    {data: 'month_year'},
                    {data: 'gross'},
                    {data: 'net_salary'},
                    {data: 'action', orderable: false},
                ]
            });
        });
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

    @can('Send Mail')
        <script>
            function sendPayrollEmail() {
                let month = $('#monthYear').val();

                if (month === 'undefined' || month === null || month === "") {
                    alert("Select Month!..");
                } else {
                    $.ajax({
                        type: "GET",
                        url: '{{ url('payroll/payslip/email') }}/' + month,
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            console.log(response);
                            if (response.status === 'success') {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'PaySlip will be Emailed soon..',
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                                $("#month").val('');

                            } else if (response.message === 'fail') {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: 'PaySlip Email Generation Process Failed!...',
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

    @can('Generate Payslip')
        <script>

            function generatePayroll() {
                let month = $('#monthYear').val();

                if (month === 'undefined' || month === null || month === "") {
                    alert("Select Month!..");
                } else {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('generatePayslipForAllEmployees') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            monthYear: month
                        },

                        success: function (response) {
                            console.log(response.status);
                            console.log(response.message);
                            if (response.status === 'success') {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })

                                $("#monthYear").val('');
                                $('#list_table').DataTable().ajax.reload();

                            } else if (response.status === 'warning') {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'warning',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#list_table').DataTable().ajax.reload();
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
                            $('#list_table').DataTable().ajax.reload();
                        }
                    });
                }
            }
        </script>
    @endcan

@endsection
