@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Vehicle List</h2>
                    @can('vehicle-create')
                    <div class="float-right ">
                        <a href="{{route('admin.vehicle.create')}}" class="btn btn-sm btn-primary">Add Vehicle</a>
                    </div>
                    @endcan
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
                            <h2>Vehicle List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="all-vehicle-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vehicle Pic</th>
                                        <th>Ride Type</th>
                                        <th>Vehicle Category</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Brand</th>
                                        <th>Vehcile Color</th>
                                        <th>Vehicle Model</th>
                                        <th>Number Of Sheets</th>
                                        <th>Status</th>
                                        <th>Created By</th>
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

                $('#all-vehicle-data').dataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "bDestroy": true,
                    'checkboxes': {
                        'selectRow': true
                    },
                    "ajax": {
                        url: "{{ route('admin.vehicle.list') }}",
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
                            "name": "vehicle_pic",
                            'searchable': false,
                            'orderable': false
                        },
                        
                        {
                            "targets": 2,
                            "name": "vehicle_type",
                            'searchable': true,
                            'orderable': true
                        },
                        
                        {
                            "targets": 3,
                            "name": "vehicle_category",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 4,
                            "name": "vehicle_number",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 5,
                            "name": "vehicle_brand",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "vehicle_color",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 7,
                            "name": "vehicle_model",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 8,
                            "name": "vehicle_seats",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 9,
                            "name": "vehicle_status",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 10,
                            "name": "created_by",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 11,
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
                let vehicleId = $(this).data('id');
                let status = $(this).data('active');
                let fd = new FormData();
                fd.append('vehicleId', vehicleId);
                fd.append('status', status);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to change status ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.vehicle.status-change') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#all-vehicle-data').DataTable().ajax.reload(null,
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
            $("body").on("click", ".vehicleRemove", function(e) {
                e.preventDefault();
                let vehicleId = $(this).data('id');
                let fd = new FormData();
                fd.append('vehicleId', vehicleId);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to delete this Vehicle ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.vehicle.remove') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#all-vehicle-data').DataTable().ajax.reload(null,
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
