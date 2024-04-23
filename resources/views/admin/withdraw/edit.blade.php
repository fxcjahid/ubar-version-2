@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.withdraw') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Edit Withdraw</h2></span>
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
                            <h2>Edit Withdraw</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="edit-withdraw" method="POST">
                            <div class="row">
                                                             <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="PENDING" {{$withdraw->status == "PENDING" ? 'selected' : ''}}>PENDING</option>
                                            <option value="APPROVED" {{$withdraw->status == "APPROVED" ? 'selected' : ''}}>APPROVED</option>
                                            <option value="CANCELLED" {{$withdraw->status == "CANCELLED" ? 'selected' : ''}}>CANCELLED</option>
                                            <option value="COMPLETED" {{$withdraw->status == "COMPLETED" ? 'selected' : ''}}>COMPLETED</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <input type="hidden" name="withdraw_id" value="{{$withdraw->id}}">
                            <div class="float-right">
                                <button type="submit" name="submit" class="btn btn-success">Withdraw</button>
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
            $('#edit-withdraw').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#edit-withdraw")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.withdraw.update') }}",
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
                                    "{{ url('admin/withdraw') }}";
                            }, 1000);
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
