@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Payment List</h2>
                    <!--@can('user-create')
        -->
                        <!--<div class="float-right ">-->
                        <!--    <a href="{{ route('admin.user.create') }}" class="btn btn-sm btn-primary">Add User</a>-->
                        <!--</div>-->
                        <!--
    @endcan-->
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <!-- table section -->
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Payment List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="all-user-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Payment Type</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                        <th>Reference No</th>
                                        <th>Mobile No</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('extra_js')
    <script>
        $(function() {
            $.fn.tableload = function() {

                $('#all-user-data').dataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "bDestroy": true,
                    'checkboxes': {
                        'selectRow': true
                    },
                    "ajax": {
                        url: "{{ route('admin.payment.list') }}",
                        "type": "GET",
                        "data": function(d) {
                            d._token = "{{ csrf_token() }}";
                        },
                        dataFilter: function(data) {
                            var json = jQuery.parseJSON(data);
                            json.recordsTotal = json.recordsTotal;
                            json.recordsFiltered = json.recordsFiltered;
                            json.data = json.data;
                            return JSON.stringify(json); // return JSON string
                        }
                    },
                    "order": [
                        [0, 'desc']
                    ],
                    "columns": [{
                            "targets": 0,
                            "name": "id",
                            'searchable': false,
                            'orderable': true
                        },
                        {
                            "targets": 1,
                            "name": "username",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 2,
                            "name": "payment_type",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 3,
                            "name": "payment_method",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 4,
                            "name": "amount",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 5,
                            "name": "transaction_no",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "mobile_no",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 7,
                            "name": "status",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 8,
                            "name": "created_at",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 9,
                            "name": "action",
                            'searchable': false,
                            'orderable': false
                        },
                    ]
                });
            }
            $.fn.tableload();

            // User Status change process
            $("body").on("click", ".statusChange", function(e) {
                e.preventDefault();
                let userId = $(this).data('id');
                let status = $(this).data('active');
                let fd = new FormData();
                fd.append('userId', userId);
                fd.append('status', status);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to change status ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.payment.status_change') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#all-user-data').DataTable().ajax.reload(null,
                                            false);
                                    } else {
                                        toast.error(result.message);
                                    }
                                })
                                .fail(function(jqXHR, exception) {
                                    console.log(jqXHR.responseText);
                                })
                        },
                        no: function() {},
                    }
                })
            })

            // User remove process
            $("body").on("click", ".userRemove", function(e) {
                e.preventDefault();
                let userId = $(this).data('id');
                let fd = new FormData();
                fd.append('userId', userId);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to delete this user ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.payment.remove') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#all-user-data').DataTable().ajax.reload(null,
                                            false);
                                    } else {
                                        toast.error(result.message);
                                    }
                                })
                                .fail(function(jqXHR, exception) {
                                    console.log(jqXHR.responseText);
                                })
                        },
                        no: function() {},
                    }
                })
            })
        });
    </script>
@endsection
@endsection
