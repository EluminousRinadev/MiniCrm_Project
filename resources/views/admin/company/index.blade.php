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
                        <form method="post" enctype="multipart/form-data" action="{{ $moduleUrlPath}}/importExcel"
                            data-parsley-validate>
                            {{ csrf_field() }}
                            <div class="form-group">
                                <table class="table">
                                    <tr>
                                        <td width="40%" align="right"><label>Select File for Upload</label></td>
                                        <td width="30">
                                            <input type="file" name="selectFile"
                                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                                required
                                                data-parsley-required-message='<p style="color:red;">Only Accept .xls, .xslx Format files</p>' />
                                        </td>
                                        <td width="30%" align="left">
                                            <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%" align="right"></td>

                                        <td width="30%" align="left"></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                        <form action="{{$moduleUrlPath}}/exportExcel" method="POST" id="export_form">
                            {{ csrf_field() }}
                            <table id="ajax-datatable" class="table table-bordered">
                                <!-- <a class="btn btn-primary" href="{{ $moduleUrlPath}}/exportExcel">ExportCompany
                                Data</a><br><br> -->
                                <input type="button" id="btn_export_csv" value="Export CSV"
                                    class="btn btn-primary"><br><br>
                                <thead>
                                    <tr>
                                        <th><label><input type="checkbox" class="filled-in"
                                                    id="selectall" /><span></span></label>Id</th>
                                        <th> Company Name
                                            <input type="text" name="q_name" placeholder="Search"
                                                class="search-block-new-table column_filter" />
                                        </th>
                                        <th> Email
                                            <input type="text" name="q_email" placeholder="Search"
                                                class="search-block-new-table column_filter" />
                                        </th>
                                        <th> logo </th>
                                        <th> website
                                            <input type="text" name="q_website" placeholder="Search"
                                                class="search-block-new-table column_filter" />
                                        </th>
                                        <th><span class="datatable_filter">Status</span>
                                            <select class="search-block-new-table column_filter" id="q_status"
                                                name="q_status">
                                                <option value="">Select</option>
                                                <option value="1">Active</option>
                                                <option value="0">DeActive</option>
                                            </select>
                                        </th>
                                    </tr>
                                </thead>


                                <tbody>

                                </tbody>
                            </table>
                        </form>
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

<script type="text/javascript">
function filterData() {
    table_module.draw()
}
$(document).ready(function() {
    table_module = $("#ajax-datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ $moduleUrlPath}}/loadData",
            data: function(e) {
                e["column_filter[q_name]"] = $("input[name='q_name']").val(),
                    e["column_filter[q_email]"] = $("input[name='q_email']").val(),
                    e["column_filter[q_website]"] = $("input[name='q_website']").val(),
                    e["column_filter[q_status]"] = $("select[name='q_status']").val()
            }
        },
        columns: [{
                render: function(e, a, t, l) {
                    return '<label><input type="checkbox" class="select-all filled-in" name="checked_record[]" value="' +
                        t.id + '" /><span></span></label>';
                },
                orderable: false,
                searchable: false
            },
            {
                data: "name",
                orderable: false,
                searchable: true,
                name: "name"
            },
            {
                data: "email",
                orderable: false,
                searchable: true,
                name: "email"
            },

            {
                data: "website",
                orderable: false,
                searchable: true,
                name: "website"
            },

            {
                render: function(data, type, row, meta) {
                    return row.statusBtn;
                },
                orderable: false,
                searchable: true
            },
            {
                render: function(data, type, row, meta) {
                    return row.actionBtn;
                },
                orderable: false,
                searchable: false
            }
        ]
    })

});
$("input.column_filter").on("keyup", function() {
    filterData()
});
$("select.column_filter").on("change ", function() {
    filterData()
});

$("#btn_export_csv").click(function() {

    $('#export_form').submit();
});
</script>

@endsection