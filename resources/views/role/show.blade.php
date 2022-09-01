@extends('layouts.layout')

@section('content')
    <style>
        .page-content {
            width: calc(100% - 17rem);
            margin-left: 17rem;
            transition: all 0.4s;
            padding: 12px!important;
        }
    </style>
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

            <div class="row mt-5">

                <div class="col-md-12">

                    <div class="card">
                    <div class="card-header"><h5 class="text-center">View Roles and Permission</h5></div>
                        <form class="form-validate" action="{{ $role ? route('role.update', $role->id) : route('role.store') }}" method="post">
                            @csrf
                            @if($role) @method('PUT') @endif
                            <div class="card-body">
                                <div class="row">
                                    <label for="inputName" class="col-md-2 form-label">Role Name</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="val-username" name="name"
                                               value="{{ $role ? old('name', $role->name) : old('name') }}" placeholder="Enter a role.." required disabled>
                                        @error('name')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <br><br>
                                <h4 class="">Assigned Permissions</h4>
                                <hr>
                                <div>
                                    @foreach($permissions as $guardName => $guards)
                                        <div class="mt-3">
                                            <h6><b>{{ snakeCaseToTitleCase($guardName) }}</b></h6>
                                        </div>
                                        <div class="row mt-3">
                                            @foreach($guards as $permission)
                                                <div class="col-md-3">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="permissions[]" id="{{ $permission->id}}"
                                                               value="{{ $permission->id}}" {{ ($role && $role->hasPermissionTo($permission->name)) ? "checked" : '' }} disabled>
                                                        <span class="custom-control-label" for="{{ $permission->id}}">{{ snakeCaseToTitleCase($permission->name) }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>

                                <div class="">
                                    <div class="row mb-5 mt-5">
                                        <div class="col-md-5"></div>
                                        <div class="col-md-1">
                                            <div class="text-center mt-5">
                                                <a href="{{ route('role.index') }}">
                                                    <button type="button" class="btn btn-light btn-outline-shift-primary px-4 btn-sm"><span class="small">Cancel</span></button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-5"></div>
                                    </div>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- CONTAINER END -->
    </div>
@endsection

@section('script')
@endsection
