@extends('admin.layouts.layout')


@section('section')
    <div class="container-fluid vehicles-discount-list">
        <div class="row">
            <!-- table section -->
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Vehicle Discount List</h2>
                        </div>
                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="all-vehicle-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Vehicle Type</th>
                                        <th>Vehicle Number</th>
                                        <th>Discount Code</th>
                                        <th>Discount Type</th>
                                        <th>Discount Amount</th>
                                        <th>Start</th>
                                        <th>Expired</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->vehicleType->t_name }}</td>
                                            <td>{{ $item->vehicle_number }}</td>
                                            <td>{{ $item->discount_code }}</td>
                                            <td>{{ $item->discount_type }}</td>
                                            <td>{{ $item->discount_amount }}</td>
                                            <td>{{ $item->start_at }}</td>
                                            <td>{{ $item->expired_at }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                            <td>Action</td>
                                        </tr>
                                    @endforeach
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
                    "bDestroy": true,
                    "order": [
                        [0, 'desc']
                    ],
                    "columns": [{
                            "targets": 0,
                            "name": "id",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 1,
                            "name": "name",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 2,
                            "name": "vehicle_type",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 3,
                            "name": "vehicle_number",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 4,
                            "name": "discount_code",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 5,
                            "name": "discount_type",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "discount_amount",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 7,
                            "name": "status",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 8,
                            "name": "start_at",
                            'searchable': false,
                            'orderable': true
                        },
                        {
                            "targets": 9,
                            "name": "expired_at",
                            'searchable': false,
                            'orderable': true
                        },
                        {
                            "targets": 10,
                            "name": "created",
                            'searchable': false,
                            'orderable': true
                        },
                        {
                            "targets": 11,
                            "name": "action",
                            'searchable': false,
                            'orderable': false
                        }
                    ]
                });
            }
            $.fn.tableload();
        });
    </script>
@endsection
@endsection
