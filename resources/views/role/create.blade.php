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
        <div class="container-fluid">

            <div class="row mt-5">

                <div class="col-md-12">

                    <div class="card">
                        <div class="card-header"><h5 class="text-center">Roles and Permission</h5></div>
                        <form class="form-validate" action="{{ $role ? route('role.update', $role->id) : route('role.store') }}" method="post">
                            @csrf
                            @if($role) @method('PUT') @endif
                            <div class="card-body">
                                <div class="row">
                                    <label for="inputName" class="col-md-2 form-label">Role Name</label>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="val-username" name="name"
                                               value="{{ $role ? old('name', $role->name) : old('name') }}" placeholder="Enter a role.." required>
                                        @error('name')
                                        <span class="error invalid-feedback">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <h4 class="mt-5">Assign Permissions</h4>
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
                                                               value="{{ $permission->id}}" {{ ($role && $role->hasPermissionTo($permission->name)) ? "checked" : '' }}>
                                                        <span class="custom-control-label" for="{{ $permission->id}}">{{ snakeCaseToTitleCase($permission->name) }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row mt-5 justify-content-center">
                                    <div class="col-md-4">

                                        <a href="{{ route('role.index') }}">
                                         <button type="button" class="btn btn-sm px-5 mb-2 btnPrimaryCustomizeBlueOutline mr-4">Cancel</button>
                                        </a>
                                        <button type="submit" class="btn btn-sm px-5 mb-2 btnPrimaryCustomizeBlue text-light">Save</button>
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
