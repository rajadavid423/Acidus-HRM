@extends('layouts.layout')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="container-fluid">
                    <div class="titles d-flex justify-content-between">
                        <div class="mr-auto"><h5>Import Employee</h5></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid mt-3">
        <form method="POST" id="employee" action="{{ route('bulk-employee.store')  }}" autocomplete="off" enctype="multipart/form-data">
            <div class="card-body">
                @csrf

                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xl-4 col-md-4">
                            <label for="inputGroupFile02" class="form-label"> Excel Import </label>

                            <div class="input-group mb-3 d-flex">
                                <input required type="file" name="excelFile" class="form-control form-control-md mr-2" id="inputGroupFile02">
                                <button type="submit" class="btn btn-shift-primary btn-md px-4 mb-2">Upload</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-md-4">
                            <a href="{{ asset('sampleExcels/users.csv') }}" download style="cursor:pointer;">  Download Sample File </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
@section('script')
@endsection
