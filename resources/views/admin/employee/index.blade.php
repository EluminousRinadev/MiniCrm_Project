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
                                    

                                    <table id="datatable" class="table table-bordered">
                                        <thead>
                                        <tr>
                          <th>Id</th>
   
                          <th> First Name </th>
                          <th> Last Name </th>
                          <th> Company Name </th>
                          <th> Email</th>
                          <th> Phone No</th>
                          <th> Action</th>
                        </tr>
                                        </thead>


                                        <tbody>
                                        @foreach($employee as $user)
                                        <tr>
                        <td>
                        {{ $user['id'] }}
                          </td>  
                          <td >
                           {{$user['first_name']}}
                          </td>
                          <td>{{$user['last_name']}}</td>
                          <td>
                            {{$user['company']['name']}}
                    
                          </td>
                          <td>  {{$user['email']}} </td>
                          <td> {{$user['phone']}}</td>

                          
                         @php
                        $delete_url = url('admin/employee/delete').'/'.base64_encode($user['id'] ?? '');
                        $edit_url = url('admin/employee/edit').'/'.base64_encode($user['id'] ?? '');
                        @endphp


                          <td><a href="{{ $edit_url ?? '' }}"><button>edit<a></button>
                          <a href="{{ $delete_url ?? '' }}" onclick="return confirm('Do you want to delete?')"><button>Delete</button><a></td>
                         
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

