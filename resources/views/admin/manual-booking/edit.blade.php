@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.manual-booking') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Edit Manual Booking</h2></span>
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
                            <h2>Edit Manual Booking</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="add-booking" method="POST">
                            <div class="row">

                            <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Type</label>
                                        <select class="form-control type" name="type" required>
                                            <option value="">Select Type</option>
                                            @foreach ($types as $type)
                                            <option {{$type->id == $booking->type_id ? 'selected':''}} value="{{$type->id}}">{{$type->t_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Category</label>
                                        <select class="form-control category" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                            @foreach ($categories as $category )
                                                
                                            <option {{$category->id == $booking->category_id ? 'selected':''}} value="{{$category->id}}">{{$category->category_name}}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Driver</label>
                                        <select class="form-control " name="driver" required>
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                            <option {{$driver->id == $booking->driver_id ? 'selected':''}} value="{{$driver->id}}">{{$driver->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Customer Name</label>
                                        <input type="text" class="form-control" name="customer"
                                            placeholder="Enter Customer Name" required value="{{$booking->customer_name}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Phone Number</label>
                                        <input type="number" step="any"  class="form-control" name="phone" required value="{{$booking->phone}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email" value="{{$booking->email}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Booking Start Date</label>
                                        <input type="date" class="form-control" name="start_date" required value="{{$booking->booking_start_date}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Booking End Date</label>
                                        <input type="date" class="form-control" name="end_date" required value="{{$booking->booking_end_date}}">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pickup location</label>
                                        <input type="text" value="{{$booking->pickup_location}}" class="form-control" name="pickup_location" placeholder="Enter Pickup location">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Drop location</label>
                                        <input type="text" value="{{$booking->drop_location}}" class="form-control" name="drop_location" placeholder="Enter drop location">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Distance</label>
                                        <input type="text" value="{{$booking->distance}}" class="form-control" name="distance" placeholder="Enter Distance">
                                    </div>
                                </div>


                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Advance Amount</label>
                                        <input type="number" step="any" min="1" class="form-control" name="advance_amount" placeholder="0.00" required value="{{$booking->advance_amnt}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Pending Amount</label>
                                        <input type="number" step="any" min="1" class="form-control" name="pending_amount" placeholder="0.00" required value="{{$booking->pending_amnt}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Total Amount</label>
                                        <input type="number" step="any" min="1" class="form-control" name="total_amount" placeholder="0.00" required value="{{$booking->total_amnt}}">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="bookingId" value="{{$booking->id}}">
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
            $('#add-booking').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-booking")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.manual.update') }}",
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
                                    "{{ url('admin/manual-booking') }}";
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

        

        $(document).ready(function() {
        $('select[name="type"]').on('change', function() {
            var typeID = $(this).val();
            if(typeID) {
                $.ajax({
                    url: '/admin/get-category/'+typeID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {                      
                        $('select[name="category"]').empty();
                        $.each(data, function(key, value) {
                        $('select[name="category"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="category"]').empty();
            }
        });
    });

    </script>
@endsection
@endsection
