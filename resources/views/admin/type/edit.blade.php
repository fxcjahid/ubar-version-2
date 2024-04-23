@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('type.index') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Edit Type</h2></span>
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
                            <h2>Edit Type</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="update-type" method="POST">
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type Name</label>
                                        <input type="text" class="form-control" name="t_name"
                                            placeholder="Enter Type Name" required value="{{$type->t_name}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type Status</label>
                                        <select class="form-control" name="t_status" required>
                                            <option value="">Select Status</option>
                                            <option value="PENDING" {{$type->t_status == "PENDING" ? 'selected' : ''}}>PENDING</option>
                                            <option value="APPROVED" {{$type->t_status == "APPROVED" ? 'selected' : ''}}>APPROVED</option>
                                            <option value="REJECTED" {{$type->t_status == "REJECTED" ? 'selected' : ''}}>REJECTED</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <input type="hidden" name="id" value="{{$type->id}}">
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
            $('#update-type').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#update-type")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.type.update') }}",
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
                            $("#update-type")[0].reset();
                            setTimeout(function() {
                                window.location.href =
                                    "{{ url('admin/type') }}";
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
