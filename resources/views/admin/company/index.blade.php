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

                        <table id="ajax-datatable" class="table table-bordered">
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
            url: "{{ $moduleUrlPath}}/load_data",
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
                    return row.status_btn;
                },
                orderable: false,
                searchable: true
            },
            {
                render: function(data, type, row, meta) {
                    return row.action_btn;
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
</script>

@endsection