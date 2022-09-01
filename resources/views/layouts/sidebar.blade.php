<!--    Sidebar-->

<div class="vertical-nav" id="sidebar" style="background-color: #0F75BD;">

    <ul class="nav flex-column mb-0 mt-lg-1">

        <li class="nav-item nav_border_style p-2">
            <a href="{{ route('home') }}" class="nav-link text-light">
                <i class="fa-solid fa-chart-line  mr-4"></i>Dashboard
            </a>
        </li>

        @canany(['Create Employee','Edit Employee','View Employee','Delete Employee'])
            <li class="nav-item nav_border_style p-2">
                <a href="{{route('Employee.index')}}" class="nav-link text-light ">
                    <i class="fa-regular fa-user mr-4"></i>Employee
                </a>
            </li>
        @endcanany

        @canany(['Generate Payslip','Send Mail','Edit Payslip','View Payslip'])
            <li class="nav-item nav_border_style p-2">
                <a href="{{route('payroll.index')}}" class="nav-link text-light ">
                    <i class="fa-solid fa-coins mr-4"></i>Payroll
                </a>
            </li>
        @endcanany

        @canany(['Leave Approval','Leave Apply'])
            <li class="nav-item nav_border_style p-2">
                <a href="{{route('leave.index')}}" class="nav-link text-light ">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-4"></i>Leave
                </a>
            </li>
        @endcanany

        @canany(['Shift','Designation','Process','Team','Client','Salary Percentage','Roles'])
            {{--        dropdown Customize menu--}}
            <li class="nav-item nav_border_style p-2">
                {{--        dropdown menu title--}}
                <a href="#" class="nav-link text-light" data-toggle="collapse"
                   data-target="#customize">
                    <i class="fa-solid fa-gear mr-4"></i>Customize<i class="fa-solid fa-angle-down ml-5 pl-3"></i>
                </a>

                {{--        dropdown Customize sub menu--}}

                <div id="customize" class="collapse">
                    <ul class="nav flex-column mb-0 mx-4">
                        @can('Shift')
                            <li class="nav-item">
                                <a href="{{route('shift.index')}}" class="nav-link text-light pl-5">
                                    Shift
                                </a>
                            </li>
                        @endcan

                        @can('Designation')
                            <li class="nav-item">
                                <a href="{{ route('designation.index')}}" class="nav-link text-light  pl-5">
                                    Designation
                                </a>
                            </li>
                        @endcan

                        @can('Process')
                            <li class="nav-item">
                                <a href="{{ route('process.index')}}" class="nav-link text-light pl-5">
                                    Process
                                </a>
                            </li>
                        @endcan

                        @can('Team')
                            <li class="nav-item">
                                <a href="{{ route('team.index')}}" class="nav-link text-light pl-5">
                                    Team
                                </a>
                            </li>
                        @endcan

                        @can('Client')
                            <li class="nav-item">
                                <a href="{{ route('client.index')}}" class="nav-link text-light pl-5">
                                    Client
                                </a>
                            </li>
                        @endcan

                        @can('Salary Percentage')
                            <li class="nav-item">
                                <a href="{{ route('salary-percentage.show')}}" class="nav-link text-light  pl-5">
                                    Salary Percentage
                                </a>
                            </li>
                        @endcan

                        @can('Roles')
                            <li class="nav-item">
                                <a href="{{ route('role.index')}}" class="nav-link text-light pl-5">
                                    Roles
                                </a>
                            </li>
                        @endcan
                            @can('Branch')
                                <li class="nav-item">
                                    <a href="{{ route('branch.index')}}" class="nav-link text-light pl-5">
                                        Branch
                                    </a>
                                </li>
                            @endcan
                            @can('Bank')
                                <li class="nav-item">
                                    <a href="{{ route('bank.index')}}" class="nav-link text-light pl-5">
                                        Bank
                                    </a>
                                </li>
                            @endcan
                            @can('Export Payroll')
                                <li class="nav-item">
                                    <a href="{{ route('import-employee-excel')}}" class="nav-link text-light pl-5">
                                        Employee Bulk Upload
                                    </a>
                                </li>
                            @endcan

                    </ul>
                </div>
                {{--        dropdown Customize sub menu end--}}
            </li>
            {{--        dropdown Customize menu end--}}
        @endcanany
    </ul>
</div>


<!--    Sidebar end-->
