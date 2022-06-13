@extends('admin.layout.master') 
@section('main_content')
@include('layouts.flash-message')



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
         

            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title float-left">Company</h4>

                                    <!-- <ol class="breadcrumb float-right">
                                        <li class="breadcrumb-item"><a href="#">Abstack</a></li>
                                        <li class="breadcrumb-item"><a href="#">Tables</a></li>
                                        <li class="breadcrumb-item active">Datatable</li>
                                    </ol> -->

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->


                        <div class="row">
                            <div class="col-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b></b></h4>
                                    @include('layouts.flash-message')

                                    <table id="datatable" class="table table-bordered">
                                        <thead>
                                        <tr>
                        <th>Id</th>
   
   
                           <th> Company Name </th>
                          <th> Email</th>
                          <th> logo</th>
                          <th> website</th>
                          <th> Action</th>
                        </tr>
                                        </thead>


                                        <tbody>
                                        @foreach($company as $data)
                                        <tr>
                                            <td>{{ $data['id'] }}</td>
                                            <td>{{$data['name']}}</td>
                                            <td>{{$data['email']}}</td>
                                            <td>   @if(isset($data['logo']) && !empty($data['logo']) )

<img src="{{ $logo_image_public_path.$data['logo'] }}" alt="" height="100" width="100">

@else

<img src="{{url('/').'/storage/app/public/default.png' }}" alt="" height="100" width="100">

@endif</td>
                                            <td> {{$data['website']}}</td>
                                            @php
                        $delete_url = url('admin/company/delete').'/'.base64_encode($data['id'] ?? '');
                        $edit_url = url('admin/company/edit').'/'.base64_encode($data['id'] ?? '');
                        @endphp

                                            <td><a href="{{ $edit_url ?? '' }}"><button>edit<a></button>
                          <a href="{{ $delete_url ?? '' }}" onclick="return confirm('Do you want to delete ?')"><button>Delete</button><a></td>
                                        </tr>
                                   
                                        @endforeach
                                      
                                       



                                   
                                     
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> <!-- end row -->


                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                @include('admin.layout._footer_content')


            </div>

       

<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

