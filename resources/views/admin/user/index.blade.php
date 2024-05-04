@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>User List</h2>
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
                            <h2>User List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="all-user-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
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
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->userInfo->gender }}</td>
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
            // $.fn.tableload = function() {

            //     $('#all-user-data').dataTable({
            //         "processing": true,
            //         pageLength: 10,
            //         "serverSide": true,
            //         "bDestroy": true,
            //         'checkboxes': {
            //             'selectRow': true
            //         },
            //         "ajax": {
            //             url: "{{ route('admin.user.list') }}",
            //             "type": "GET",
            //             "data": function(d) {
            //                 d._token = "{{ csrf_token() }}";
            //             },
            //             dataFilter: function(data) {
            //                 return JSON.stringify(data); // return JSON string
            //             }
            //         },
            //         "order": [
            //             [0, 'desc']
            //         ],
            //         "columns": [{
            //                 "targets": 0,
            //                 "name": "id",
            //                 'searchable': false,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 1,
            //                 "name": "profile_pic",
            //                 'searchable': false,
            //                 'orderable': false
            //             },
            //             {
            //                 "targets": 1,
            //                 "name": "name",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 2,
            //                 "name": "email",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 3,
            //                 "name": "phone",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 4,
            //                 "name": "emergency_number",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 5,
            //                 "name": "address",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 6,
            //                 "name": "gender",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 7,
            //                 "name": "active",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 8,
            //                 "name": "created_at",
            //                 'searchable': true,
            //                 'orderable': true
            //             },
            //             {
            //                 "targets": 9,
            //                 "name": "action",
            //                 'searchable': false,
            //                 'orderable': false
            //             },
            //         ]
            //     });
            // }
            // $.fn.tableload();

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
                                    url: "{{ route('admin.user.status_change') }}",
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
                                    url: "{{ route('admin.user.remove') }}",
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
