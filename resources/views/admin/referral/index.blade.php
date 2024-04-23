@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <br /><br />
        <div class="row">
            <!-- table section -->
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Referral Registration List</h2>
                        </div>
                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="referral-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Referral ID</th>
                                        <th>Referral Name</th>
                                        <th>Referred ID</th>
                                        <th>Referred Name</th>
                                        <th>Referral Code</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->referrer->id }}</td>
                                            <td>{{ $item->referrer->name }}</td>
                                            <td>{{ $item->referred->id }}</td>
                                            <td>{{ $item->referred->name }}</td>
                                            <td>{{ $item->referral_code }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
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

                $('#referral-data').dataTable({
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
                            "name": "referral_id",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 2,
                            "name": "referral_name",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 3,
                            "name": "referred_id",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 4,
                            "name": "referred_name",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 5,
                            "name": "referral_code",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 6,
                            "name": "status",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 7,
                            "name": "create_date",
                            'searchable': true,
                            'orderable': true
                        }
                    ]
                });
            }
            $.fn.tableload();
        });
    </script>
@endsection
@endsection
