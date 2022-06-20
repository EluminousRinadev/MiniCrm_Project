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


                        <table id="ajax-datatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> <label><input type="checkbox" class="filled-in"
                                                id="selectall" /><span></span></label>Id</th>

                                    <th> First Name
                                        <input type="text" name="q_first_name" placeholder="Search"
                                            class="search-block-new-table column_filter" />
                                    </th>
                                    <th> Last Name
                                        <input type="text" name="q_last_name" placeholder="Search"
                                            class="search-block-new-table column_filter" />
                                    </th>

                                    <th>

                                        <span class="datatable_filter">Company</span>
                                        <select class="search-block-new-table column_filter" id="q_company"
                                            name="q_company">
                                            <option value="">Select</option>
                                            @foreach($employee as $row)
                                            <option value="{{  $row['company']['id'] }}">{{  $row['company']['name'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th> Email
                                        <input type="text" name="q_email" placeholder="Search"
                                            class="search-block-new-table column_filter" />
                                    </th>
                                    <th> Phone No
                                        <input type="text" name="q_phone" placeholder="Search"
                                            class="search-block-new-table column_filter" />
                                    </th>
                                    <th>
                                        <span class="datatable_filter">Status</span>
                                        <select class="search-block-new-table column_filter" id="q_status"
                                            name="q_status">
                                            <option value="">Select</option>
                                            <option value="1">Active</option>
                                            <option value="0">DeActive</option>
                                        </select>
                                    </th>
                                    <th> Action</th>
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
            url: "{{ $moduleUrlPath}}/loadData",
            data: function(e) {
                e["column_filter[q_first_name]"] = $("input[name='q_first_name']").val(),
                    e["column_filter[q_last_name]"] = $("input[name='q_last_name']").val(),
                    e["column_filter[q_company]"] = $("select[name='q_company']").val(),
                    e["column_filter[q_email]"] = $("input[name='q_email']").val(),
                    e["column_filter[q_phone]"] = $("input[name='q_phone']").val(),
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
                data: "first_name",
                orderable: false,
                searchable: true,
                name: "first_name"
            },
            {
                data: "last_name",
                orderable: false,
                searchable: true,
                name: "last_name"
            },
            {
                data: "company",
                orderable: false,
                searchable: true,
                name: "company"
            },
            {
                data: "email",
                orderable: false,
                searchable: true,
                name: "email"
            },
            {
                data: "phone",
                orderable: false,
                searchable: true,
                name: "phone"
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
</script>

@endsection