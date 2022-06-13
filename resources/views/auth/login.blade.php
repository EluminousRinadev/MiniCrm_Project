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

        <!-- App css -->
        <link href="{{ url('/assets/admin/') }}/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/admin/') }}/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/admin/') }}/css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/assets/admin/') }}/css/style.css" rel="stylesheet" type="text/css" />

        <script src="{{ url('/assets/admin/') }}/js/modernizr.min.js"></script>

    </head>


    <body class="bg-accpunt-pages">

   
    
        <!-- HOME -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">

                        <div class="wrapper-page">

                            <div class="account-pages">
                                <div class="account-box">
                                    <div class="account-logo-box">
                                        <h2 class="text-uppercase text-center">
                                            <!-- <a href="index.html" class="text-success">
                                                <span><img src="{{ url('/assets/admin/') }}/images/logo_dark.png" alt="" height="18"></span>
                                            </a> -->
                                        </h2>
                                        @include('layouts.flash-message')
                                        <h6 class="text-uppercase text-center font-bold mt-4">Admin Panel</h6>
                                    </div>
                                    <div class="account-content">
                                        <form class="form-horizontal" method="POST" action="{{ url('/loginProcess') }}" data-parsley-validate>
                                        @csrf
                                            <div class="form-group m-b-20 row">
                                                <div class="col-12">
                                                    <label for="emailaddress">Email address</label>
                                                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="emailaddress" required="" placeholder="Enter your email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('Email Address') }}" required   data-parsley-required-message ='<p style="color:red;">Email is required</p>'>
                                                    
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert" style="color:white;">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-group row m-b-20">
                                                <div class="col-12">
                                                    <a href="page-recoverpw.html" class="text-muted pull-right"></a>
                                                    <label for="password">Password</label>
                                                    <input class="form-control @error('password') is-invalid @enderror" type="password" required="" id="password" placeholder="Enter your password" name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}" required   data-parsley-required-message ='<p style="color:red;">Password is required</p>'>
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                </div>
                                            </div>

                                            <!-- <div class="form-group row m-b-20">
                                                <div class="col-12">

                                                    <div class="checkbox checkbox-success">
                                                        <input id="remember" type="checkbox" checked="">
                                                        <label for="remember">
                                                            Remember me
                                                        </label>
                                                    </div>

                                                </div>
                                            </div> -->

                                            <div class="form-group row text-center m-t-10">
                                                <div class="col-12">
                                                    <button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Login</button>
                                                </div>
                                            </div>

                                        </form>

                                        <!-- <div class="row m-t-50">
                                            <div class="col-sm-12 text-center">
                                                <p class="text-muted">Don't have an account? <a href="page-register.html" class="text-dark m-l-5"><b>Sign Up</b></a></p>
                                            </div>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                            <!-- end card-box-->


                        </div>
                        <!-- end wrapper -->

                    </div>
                </div>
            </div>
        </section>
        <!-- END HOME -->



        <!-- jQuery  -->
        <script src="{{ url('/assets/admin/') }}/js/jquery.min.js"></script>
        <script src="{{ url('/assets/admin/') }}/js/popper.min.js"></script>
        <script src="{{ url('/assets/admin/') }}/js/bootstrap.min.js"></script>
        <script src="{{ url('/assets/admin/') }}/js/metisMenu.min.js"></script>
        <script src="{{ url('/assets/admin/') }}/js/waves.js"></script>
        <script src="{{ url('/assets/admin/') }}/js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="{{ url('/assets/admin/') }}/js/jquery.core.js"></script>
        <script src="{{ url('/assets/admin/') }}/js/jquery.app.js"></script>
        <script src="http://parsleyjs.org/dist/parsley.js"></script>
    </body>
</html>