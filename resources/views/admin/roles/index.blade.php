@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
    <div class="row column_title">
       <div class="col-md-12">
          <div class="page_title ">
                <h2>Role Management</h2>
                @can('role-create')
             <div class="float-right ">
                <a href="{{ route('roles.create')}}" class="btn btn-primary btn-sm ">Add Role</a>
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
                   <h2>Role List</h2>
                </div>

             </div>
             <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                   <table id="category-data"  class="table display nowrap">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                         </tr>
                      </thead>
                      <tbody>
                      @foreach ($roles as $key => $role)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                @can('role-edit')
                                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                @endcan
                                @can('role-delete')
                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                      </tbody>
                   </table>
                   {!! $roles->render() !!}
                </div>
             </div>
          </div>
       </div>
    </div>
    </div>

@endsection
