@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('roles.index') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Show Role</h2></span>
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
                            <h2>Create Role</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        {{ $role->name }}
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                    <div class="form-group">
                                    <strong>Permissions:</strong>
                                    @if(!empty($rolePermissions))
                                        @foreach($rolePermissions as $v)
                                        <span class="badge badge-pill badge-primary">{{ $v->name }}</span>
                                        @endforeach
                                    @endif
                                    </div>
                                </div>

                            </div>

                            <div class="float-right">
                                <button type="submit" name="submit" class="btn btn-success">Update</button>
                            </div>
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
