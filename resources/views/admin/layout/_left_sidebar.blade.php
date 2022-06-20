@php
$module_segment = Request::segment(2);
$current_page_segment = Request::segment(3);
$current_page_next_segment = Request::segment(4);
$admin_path = config('app.project.admin_panel_slug');

$create_segment=$module_segment.'/'.$current_page_segment;
@endphp
<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <!-- <li class="menu-title">Navigation</li> -->

                <li>
                    <a href="javascript: void(0);" class="@if($module_segment == 'company' ) active @endif"><i
                            class="fi-briefcase"></i> <span>Company</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{route('companyCreate')}}"
                                class="@if($module_segment == 'companyCreate') active @endif">Create</a></li>
                        <li><a href="{{route('admin.company')}}"
                                class="@if($current_page_segment == 'company') active @endif">View</a></li>

                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="@if($module_segment == 'employee') active @endif"><i
                            class="fi-briefcase"></i> <span>Employee</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{route('employeeCreate')}}"
                                class="@if($module_segment == 'employeeCreate') active @endif">Create</a></li>
                        <li><a href="{{route('admin.employee')}}"
                                class="@if($current_page_segment == 'employee') active @endif">View</a></li>

                    </ul>
                </li>







            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->