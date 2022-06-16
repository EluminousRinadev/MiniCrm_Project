@extends('admin.layout.master')
@section('main_content')
@include('layouts.flash-message')
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Creat Employee</h4>


                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-md-12">


                    <div class="card-box">
                        <h4 class="header-title m-t-0 m-b-20"></h4>
                        @include('layouts.flash-message')
                        <form class="row" method="post" action="{{route('employee.update')}}" data-parsley-validate
                            enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input type="hidden" name="enc_id" value="{{ base64_encode($arr_employee['id']) }}">
                            <div class="col-12 col-sm-6 form-group">
                                <label>First Name</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="First Name" name="first_name"
                                        required
                                        data-parsley-required-message='<p style="color:red;">First Name is required</p>'
                                        value="{{$arr_employee['first_name']}}" />
                                    @if($errors->has('first_name'))
                                    <div class="text-danger">{{ $errors->first('first_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label>Last Name</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name"
                                        required
                                        data-parsley-required-message='<p style="color:red;">Last Name is required</p>'
                                        value="{{$arr_employee['last_name']}}" />
                                    @if($errors->has('first_name'))
                                    <div class="text-danger">{{ $errors->first('first_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label>Email</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Email" name="email" required
                                        data-parsley-required-message='<p style="color:red;">Email is required</p>'
                                        data-parsley-type="email"
                                        data-parsley-email-message='<p style="color:red;">must be a valid email address</p>'
                                        value="{{$arr_employee['email']}}" />
                                    @if($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 form-group">
                                <label>Phone</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Phone" name="phone" required
                                        data-parsley-required-message='<p style="color:red;">Phone is required</p>'
                                        data-parsley-trigger='change focusout' data-parsley-class-handler='email-group'
                                        data-parsley-minlength='2' data-parsley-maxlength='10'
                                        value="{{$arr_employee['phone']}}" />
                                    @if($errors->has('phone'))
                                    <div class="text-danger">{{ $errors->first('phone') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label>Company</label>
                                <div>
                                    <select class="form-control" id="exampleSelectGender" name="company_id" required
                                        data-parsley-required-message='<p style="color:red;">Please Select Company</p>'>
                                        <option value="" disabled selected>Choose Company</option>
                                        @foreach($company as $comp)

                                        <option value="{{$comp['id']}}" @if(isset($arr_employee['company_id']) &&
                                            $arr_employee['company_id']==$comp['id']) selected @endif> {{$comp['name']}}
                                        </option>

                                        @endforeach
                                    </select>
                                    @if($errors->has('company_id'))
                                    <div class="text-danger">{{ $errors->first('company_id') }}</div>
                                    @endif
                                    @if($errors->has('company_id'))
                                    <div class="text-danger">{{ $errors->first('company_id') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-12 col-sm-6 form-group m-b-0">
                                <div>
                                    <button type="submit" class="btn btn-gradient waves-effect waves-light">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-light waves-effect m-l-5">
                                        <a href="{{url('admin/employee')}}">Cancel</a>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>




            </div>
            <!-- end row -->


            <!-- end row -->

        </div> <!-- container -->

    </div> <!-- content -->
    @endsection