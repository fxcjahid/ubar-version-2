@extends('admin.layouts.layout')
@section('extra_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('fare-category.index') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Add Fare Category</h2></span>
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
                            <h2>Create Fare Category</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="add-type" method="POST">
                            <div class="row">
                                <div class="col-4 col-sm-12 col-md-4 col-xl-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Fare Category Name</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Enter Fare Category Name" required>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-12 col-md-4 col-xl-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Start Time</label>
                                        <input type="text" class="form-control timepicker" name="start_time" required>
                                    </div>
                                </div>
                                <div class="col-4 col-sm-12 col-md-4 col-xl-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">End Time</label>
                                        <input type="text" class="form-control timepicker" name="end_time" required>
                                    </div>
                                </div>
                            </div>

                            <div class="float-right">
                                <button type="submit" name="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('extra_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    <script>
  $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 60,
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });


        $(function() {
            $('#add-type').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-type")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('fare-category.store') }}",
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
                            setTimeout(function() {
                                window.location.href =
                                    "{{ url('admin/fare-category') }}";
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
