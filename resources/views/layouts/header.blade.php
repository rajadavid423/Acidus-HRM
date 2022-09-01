{{--Header--}}

<div class="header_nav">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top shadow " style="background-color: white">
        <div class="border border-top-0 border-bottom-0 border-left-0" style="padding-right: 0.3rem!important;">
            <a href="{{ route('home') }}" class="navbar-brand text-dark">
                <img src="{{ url('images/acidusms-logo-1.png') }}" class="d-block w-55">
            </a>
        </div>

{{--        <button class="navbar-toggler p-2" type="button" data-toggle="collapse" data-target="#navbar7" style="color: #000">--}}
{{--            --}}{{--            <i class="fa-solid fa-bars"></i>--}}
{{--            <img src="../images/Gull.jpg" class="d-inline-block rounded-circle user_img">--}}
{{--        </button>--}}
        <!-- Toggle button -->
        <button id="sidebarCollapse" type="button" class="btn button_side_nav rounded-0 shadow-sm px-3 px-3 py-2 ml-3 d-lg-none d-md-block">
            <i class="fa-solid fa-bars"></i>
        </button>


        <div class="navbar-collapse  justify-content-between text-dark d-md-block d-none" id="navbar7">
            <h3>&nbsp;</h3>
            <h3 class="ml-4 mb-0 d-lg-block d-md-none font-weight-bolder">ACIDUS-HRMS</h3>
            <ul class="navbar-nav">
                <li class="nav-item header_style d-md-block d-none">
                    <a class="nav-link text-dark" href="#"><i class="fa-regular fa-bell mr-2 pt-2"></i></a>
                </li>

                <li class="nav-item header_style d-md-block d-none">
                    <a class="nav-link text-dark" href="#"><i class="fa-solid fa-gear pt-2"></i></a>
                </li>

                <li class="nav-item">
                    <div class="btn-group float-right">
                        <button type="button" class="btn btn-sm d-flex" data-toggle="dropdown" aria-expanded="false">
                           <span class="d-md-block d-none pt-2 pr-3" style="font-size: 18px;font-weight: 700;">{{ auth()->user()->name }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right position-absolute">
{{--                            TODO::Need to update the mail ID--}}
                            @if(auth()->user()->email != 'admin@gmail.com')
                            <a href="{{ route('employee.profile', auth()->id()) }}"><button class="dropdown-item" type="button">Profile</button></a>
                            @endif
                            <a onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item" type="button">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>

            </ul>

        </div>
    </nav>
</div>

{{--Header End--}}
