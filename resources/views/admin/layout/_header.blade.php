<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mini CRM</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ url('/assets/admin/') }}/images/favicon.ico">

        <!-- DataTables -->
        <link href="{{ url('/assets/admin/') }}/js/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/admin/') }}/js/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ url('/assets/admin/') }}/js/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <link href="{{ url('/assets/admin/') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/admin/') }}/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/admin/') }}/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/admin/') }}/css/style.css" rel="stylesheet" type="text/css" />

        <script src="{{ url('/assets/admin/') }}/js/modernizr.min.js"></script>
        <style>
            

.nav-second-level li.active > a {
  color: #313a46;
  background-color: #c5a36b!important;
}
        </style>

    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <a href="#" class="logo">
                        <span>
                            <!-- <img src="{{ url('/assets/admin/') }}/images/logo.png" alt="" height="50"> -->
                            MINI CRM
                        </span>
                        <i> MINI CRM
                            <!-- <img src="{{ url('/assets/admin/') }}/images/logo_sm.png" alt="" height="28"> -->
                        </i>
                    </a>
                </div>

                <nav class="navbar-custom">

                    <ul class="list-unstyled topbar-right-menu float-right mb-0">
                       
                      


                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                 <span class="ml-1">Admin <i class="mdi mdi-chevron-down"></i> </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                             
                                <!-- item-->
                                <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                                    <i class="fi-power"></i> <span>Logout</span>
                                </a>

                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="dripicons-menu"></i>
                            </button>
                        </li>
                        <!-- <li class="hide-phone app-search">
                            <form role="search" class="">
                                <input type="text" placeholder="Search..." class="form-control">
                                <a href=""><i class="fa fa-search"></i></a>
                            </form>
                        </li> -->
                    </ul>

                </nav>

            </div>
            <!-- Top Bar End -->