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
                                    <td>
                                        {{$user['first_name']}}
                                    </td>
                                    <td>{{$user['last_name']}}</td>
                                    <td>
                                        {{$user['company']['name']}}

                                    </td>
                                    <td> {{$user['email']}} </td>
                                    <td> {{$user['phone']}}</td>


                                    @php
                                    $delete_url = url('admin/employee/delete').'/'.base64_encode($user['id'] ?? '');
                                    $edit_url = url('admin/employee/edit').'/'.base64_encode($user['id'] ?? '');
                                    $active_url = url('admin/employee/active').'/'.base64_encode($user['id'] ?? '');
                                    $deactive_url = url('admin/employee/deactive').'/'.base64_encode($user['id'] ?? '');
                                    @endphp


                                    <td><a href="{{ $edit_url ?? '' }}"><button type="button"
                                                class="btn btn-primary btn-sm">edit</button><a>
                                                <a href="{{ $delete_url ?? '' }}"
                                                    onclick="return confirm('Do you want to delete?')"><button
                                                        type="button" class="btn btn-primary btn-sm">Delete</button><a>
                                                        @if($user['status']=='0')
                                                        <a href="{{ $deactive_url ?? '' }}"
                                                            onclick="return confirm('Do you want to Deactive this Records ?')"><button
                                                                type="button" class="btn btn-primary btn-sm"
                                                                style="background-color: #208336;">Active </button><a>
                                                                @else
                                                                <a href="{{  $active_url ?? '' }}"
                                                                    onclick="return confirm('Do you want to Active this Records ?')"><button
                                                                        type="button" class="btn btn-primary btn-sm"
                                                                        style="background-color: #bd0f20;">Dective
                                                                    </button><a>
                                                                        @endif
                                    </td>
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