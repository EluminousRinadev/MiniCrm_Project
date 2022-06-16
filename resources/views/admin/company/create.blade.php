@extends('admin.layout.master')
@section('main_content')

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Creat Company</h4>


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
                        <form class="row" method="post" action="{{route('company.store')}}" data-parsley-validate
                            enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="col-12 col-sm-6 form-group">
                                <label>Name</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required
                                        data-parsley-required-message='<p style="color:red;">First Name is required</p>' />
                                    @if($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label>Email</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Email" name="email" required
                                        data-parsley-required-message='<p style="color:red;">Email is required</p>'
                                        data-parsley-type="email"
                                        data-parsley-email-message='<p style="color:red;">must be a valid email address</p>' />
                                    @if($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label>Website</label>
                                <div>
                                    <input type="text" class="form-control" placeholder="Website" name="website"
                                        required
                                        data-parsley-required-message='<p style="color:red;">Website is required</p>'
                                        data-parsley-type="url" data-parsley-trigger="keyup"
                                        data-parsley-type-message='<p style="color:red;">This value should be a valid url.</p>' />
                                    @if($errors->has('website'))
                                    <div class="text-danger">{{ $errors->first('website') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 form-group">
                                <label>Logo</label>
                                <div>
                                    <input type="file" class="form-control" name="logo"
                                        data-default-file="{{url('/').'/uploads/default-profile.png' }}"
                                        onchange="return ValidateFileUpload()" id="fileChooser" />
                                    <p id="successMessage" style="color:red;"> </p>
                                </div>
                            </div>



                            <div class="col-12 col-sm-6 form-group m-b-0">
                                <div>
                                    <button type="submit" class="btn btn-gradient waves-effect waves-light">
                                        Submit
                                    </button>
                                    <button type="reset" class="btn btn-light waves-effect m-l-5">
                                        Cancel
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

    <script type="text/javascript">
    function ValidateFileUpload() {
        var fuData = document.getElementById('fileChooser');

        var FileUploadPath = fuData.value;


        if (FileUploadPath == '') {
            $("#successMessage").html("Please upload an image");


        } else {
            var Extension = FileUploadPath.substring(
                FileUploadPath.lastIndexOf('.') + 1).toLowerCase();



            if (Extension == "png" || Extension == "jpeg" || Extension == "jpg") {


                if (fuData.files && fuData.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#blah').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(fuData.files[0]);
                }

            } else {

                $("#successMessage").html("Image only allows file types of PNG, JPG and JPEG");


            }
        }
    }
    </script>