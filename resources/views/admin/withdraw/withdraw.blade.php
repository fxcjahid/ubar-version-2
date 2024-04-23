@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.withdraw') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Add Withdraw</h2></span>
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
                            <h2>Add Withdraw</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="add-withdraw" method="POST">
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Amount</label>
                                        <input type="number" step="any" min="0" class="form-control" name="amount"
                                            placeholder="Enter Withdraw Amount" required>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Users</label>
                                        <select class="form-control" name="user" required id="getAmount">
                                            <option value="">Select User</option>
                                            @foreach ($users as $user)

                                               <option value="{{$user->id}}" data-wallet="{{$user->wallet}}" >{{$user->first_name . ' ' . $user->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Available Amount</label>
                                        <input type="number" step="any" min="0" id="amount-show" class="form-control" name="available_amount" disabled placeholder="0.00">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Status</label>
                                        <select class="form-control" name="status" required>
                                            <option value="">Select status</option>
                                            <option value="PENDING">PENDING</option>
                                            <option value="APPROVED">APPROVED</option>
                                            <option value="CANCELLED">CANCELLED</option>
                                            <option value="COMPLETED">COMPLETED</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone Number</label>
                                        <input type="number" class="form-control" name="phone"  placeholder="Enter Phone Number">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email"  placeholder="Enter E-Mail">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Comment</label>
                                        <textarea type="text" class="form-control" name="comment" cols="4" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>

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
            $('#add-withdraw').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-withdraw")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.withdraw.store') }}",
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

        // get user wallet amount
        $("#getAmount").on("change" , function() {
            var availableAmnt = $(this).find(':selected').attr('data-wallet')
            $("#amount-show").val(availableAmnt);
        })
    </script>
@endsection
@endsection
