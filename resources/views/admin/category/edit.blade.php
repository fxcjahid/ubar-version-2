@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.category') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Edit Vehicle Category</h2></span>
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
                            <h2>Edit Vehicle Category</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="update-category" method="POST">
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category Name</label>
                                        <input type="text" class="form-control" name="category"
                                            placeholder="Enter Category Name" required value="{{$category->category_name}}">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Type</label>
                                        <select class="form-control" name="type" required>
                                            <option value="">Select Type</option>
                                            @foreach ($types as $type)
                                            <option {{$category->type_id == $type->id ? 'selected':''}} value="{{$type->id}}">{{$type->t_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category Status</label>
                                        <select class="form-control" name="category_status" required>
                                            <option value="">Select Status</option>
                                            <option value="PENDING" {{$category->category_status == "PENDING" ? 'selected' : ''}}>PENDING</option>
                                            <option value="APPROVED" {{$category->category_status == "APPROVED" ? 'selected' : ''}}>APPROVED</option>
                                            <option value="REJECTED" {{$category->category_status == "REJECTED" ? 'selected' : ''}}>REJECTED</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category Image</label>
                                        <input type="file" class="form-control" name="category_image">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category Icon</label>
                                        <input type="file" class="form-control" name="category_icon">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Per Person / Ton</label>
                                        <input type="text" class="form-control" name="person" required value="{{$category->person}}">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Category Description</label>
                                        <textarea type="text" class="form-control" name="description" cols="4" rows="4">{{$category->category_description}}</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="categoryId" value="{{$category->id}}">
                            </div>

                            <div class="float-right">
                                <button type="submit" name="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('extra_js')
    <script>
        $(function() {
            $('#update-category').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#update-category")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.category.update') }}",
                    type: "POST",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#load').show();
                    },
                    success: function(result) {
                        if (result.status) {
                            toast.success(result.message);
                            $("#update-category")[0].reset();
                            setTimeout(function() {
                                window.location.href =
                                    "{{ url('admin/category') }}";
                            }, 500);
                        } else {
                            toast.error(result.message);

                        }
                    },
                    complete: function() {
                        $('#load').hide();
                    },
                    error: function(jqXHR, exception) {}
                });
            })

        });
    </script>
@endsection
@endsection
