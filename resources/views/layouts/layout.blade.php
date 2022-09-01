<!DOCTYPE html>
<html lang="en">
<head>
    <title>HRM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/x-icon" href="{{asset('/images/loader.png')}}">
{{-- bootstrap cdn--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

{{--    css file link--}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">--}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

{{--    lordicon cdn--}}
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- Multi select -->
    <link href="{{ asset('css/bootstrap-select.css') }}" rel="stylesheet" />

    <!-- sweetalert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body >

{{--<div class="loading-screen" id="loading-screen">--}}
{{--    <div class="spinner-container">--}}
{{--        <span class="first"></span>--}}
{{--        <span class="bol"></span>--}}
{{--        <div class="spinner"></div>--}}
{{--    </div>--}}
{{--</div>--}}


@include('layouts.header')

<div class="container-fluid" style="margin-top: 100px!important;">
    @include('layouts.sidebar')
    @include('layouts.body')
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

{{--    datatables--}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
{{--    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>--}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
{{--    datatables--}}
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/bootstrap-select.js') }}"></script>

<!-- Select2 -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>--}}
<script>
    $("#DesignationSelect").select2({
        placeholder: "Select a Designation",
        allowClear: true
    });

    $("#ShiftSelect").select2({
        placeholder: "Select a Shift",
        allowClear: true
    });

    $("#ProcessSelect").select2({
        placeholder: "Select a Process",
        allowClear: true
    });

    $("#GenderSelect").select2({
        placeholder: "Select a Gender",
        allowClear: true
    });

    $("#teamSelect").select2({
        placeholder: "Select a team",
        allowClear: true
    });

    $("#ClientSelect").select2({
        placeholder: "Select a Client",
        allowClear: true
    });

    $("#leavetype").select2({
        placeholder: "Select a Leave Type",
        allowClear: true
    });

    $("#leaveduration").select2({
        placeholder: "Select a Leave Duration",
        allowClear: true
    });

    $("#userSelect2").select2({
        placeholder: "Select User",
        allowClear: true
    });
    $("#assignRole").select2({
        placeholder: "Select a Role",
        allowClear: true
    });
    $("#BranchSelect").select2({
        placeholder: "Select a Branch",
        allowClear: true
    });

    $("#BankSelect").select2({
        placeholder: "Select a Bank",
        allowClear: true
    });



</script>

{{-- TODO:: Need to Un-Comment when site goes to Live--}}
{{--<script>--}}

{{--    /**--}}
{{--     * Disable right-click of mouse, F12 key, and save key combinations on page--}}
{{--     */--}}
{{--    document.addEventListener("contextmenu", function(e){--}}
{{--        e.preventDefault();--}}
{{--    }, false);--}}
{{--    document.addEventListener("keydown", function(e) {--}}
{{--        //document.onkeydown = function(e) {--}}
{{--        // "I" key--}}
{{--        if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {--}}
{{--            disabledEvent(e);--}}
{{--        }--}}
{{--        // "J" key--}}
{{--        if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {--}}
{{--            disabledEvent(e);--}}
{{--        }--}}
{{--        // "S" key + macOS--}}
{{--        if (e.keyCode == 83 && (navigator.platform.match("Mac") ? e.metaKey : e.ctrlKey)) {--}}
{{--            disabledEvent(e);--}}
{{--        }--}}
{{--        // "U" key--}}
{{--        if (e.ctrlKey && e.keyCode == 85) {--}}
{{--            disabledEvent(e);--}}
{{--        }--}}
{{--        // "F12" key--}}
{{--        // if (event.keyCode == 123) {--}}
{{--        //     disabledEvent(e);--}}
{{--        // }--}}
{{--        // "C" key--}}
{{--        if (e.ctrlKey && event.keyCode == 67) {--}}
{{--            disabledEvent(e);--}}
{{--        }--}}
{{--    }, false);--}}
{{--    function disabledEvent(e){--}}
{{--        if (e.stopPropagation){--}}
{{--            e.stopPropagation();--}}
{{--        } else if (window.event){--}}
{{--            window.event.cancelBubble = true;--}}
{{--        }--}}
{{--        e.preventDefault();--}}
{{--        return false;--}}
{{--    }--}}

{{--</script>--}}


@include('common_script.alert_script')
@include('common_script.delete_script')

@yield('script')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


</body>
</html>
