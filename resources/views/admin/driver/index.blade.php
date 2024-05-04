@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Driver List</h2>
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
                            <h2>Driver List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="driver-list-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Profile</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                @if ($item->files()->where('key', 'driver_profile_picture')->exists())
                                                    <img src="{{ $item->files()->where('key', 'driver_profile_picture')->first()->path }}"
                                                        alt="Profile Picture" class="profile rounded-bottom rounded-top"
                                                        width="50px" height="50px">
                                                @else
                                                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png"
                                                        alt="Profile Picture" class="profile rounded-bottom rounded-top"
                                                        width="50px" height="50px">
                                                @endif
                                            </td>
                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.driver.document.view', ['id' => $item->id]) }}"
                                                    class="btn btn-primary btn-sm" title="view document">
                                                    <i class="fa fa-image text-white"></i>
                                                </a>
                                            </td>
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
                $('#driver-list-data').DataTable({
                    "processing": true,
                    "pageLength": 10,
                    "destroy": true,
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
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 2,
                            "name": "phone",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 3,
                            "name": "email",
                            'searchable': true,
                            'orderable': false
                        },
                        {
                            "targets": 4,
                            "name": "active_status",
                            'searchable': false,
                            'orderable': true
                        },
                        {
                            "targets": 5,
                            "name": "account_status",
                            'searchable': false,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "profile",
                            'searchable': false,
                            'orderable': false
                        },
                        {
                            "targets": 7,
                            "name": "create_date",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 8,
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
