@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>User View</h2>
                    @can('user-create')
                    <div class="float-right ">
                        <a href="{{route('admin.user.create')}}" class="btn btn-sm btn-primary">Add User</a>
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
                            <h2>View User</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table  class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Profile:</th>
                                        <td><img src="{{url($user->profile_pic)}}"  class="rounded" style="width: 50px; height: 50px;"></td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{$user->phone}}</td>
                                    </tr>
                                    <tr>
                                        <th>Emergency Number:</th>
                                        <td>{{$user->emergency_number}}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{$user->address}}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender:</th>
                                        <td>{{$user->gender}}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>{{$user->active == 1 ? "ACTIVE" : "DE-ACTIVE"}}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At:</th>
                                        <td>{{$user->created_at}}</td>
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
@endsection
