@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>City Admin List</h2>

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
                            <h2>City Admin List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="user-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Permission</th>
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

                $('#user-data').dataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "bDestroy": true,
                    'checkboxes': {
                        'selectRow': true
                    },
                    "ajax": {
                        url: "{{ route('admin.list.city-permission') }}",
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
                            "name": "name",
                            'searchable': false,
                            'orderable': false
                        },
                        {
                            "targets": 2,
                            "name": "action",
                            'searchable': false,
                            'orderable': false
                        },
                    ]
                });
            }
            $.fn.tableload();

        });
    </script>
@endsection
@endsection
