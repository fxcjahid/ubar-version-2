@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.vehicle') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Edit Vehicle</h2></span>
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
                            <h2>Edit Vehicle</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="add-vehicle" method="POST">
                            <input type="hidden" value="{{$vehicles->id}}" name="vehicleId">
                            <div class="row">
                            <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Select Ride Type</label>
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
                                        <label for="exampleInputEmail1">Select Vehicle Category</label>
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
                                        <label for="exampleInputEmail1">Vehicle Number</label>
                                        <input type="text" class="form-control" name="vehicle_number"
                                            placeholder="Enter Vehicle Number" required value="{{$vehicles->vehicle_number}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Vehicle Brand</label>
                                        <input type="text" class="form-control" name="vehicle_brand"
                                            placeholder="Enter Vehicle Brand" required value="{{$vehicles->vehicle_brand}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Vehicle Model </label>
                                            <input type="text" class="form-control" name="vehicle_model"
                                                placeholder="Phone Vehicle Model" required value="{{$vehicles->vehicle_model}}">
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Vehicle Model Year </label>
                                            <input type="text" class="form-control" name="car_model_year"
                                                placeholder="Vehicle Model Year" value="{{$vehicles->car_model_year}}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Vehicle Registration Year </label>
                                            <input type="text" class="form-control" name="car_regi_year"
                                                placeholder="Vehicle Registration Year" value="{{$vehicles->car_regi_year}}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Owner Name </label>
                                            <input type="text" class="form-control" name="owner_name"
                                                placeholder="Owner Name" value="{{$vehicles->owner_name}}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Owner Phone </label>
                                            <input type="text" class="form-control" name="owner_mobile"
                                                placeholder="Owner Phone" value="{{$vehicles->owner_mobile}}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Owner Email </label>
                                            <input type="text" class="form-control" value="{{$vehicles->owner_email}}" name="owner_email"
                                                placeholder="Owner Email" >
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Vehicle Color</label>
                                            <input type="text" class="form-control" name="vehicle_color"
                                                placeholder="Enter Vehicle Color" required value="{{$vehicles->vehicle_color}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Vehicle Seat</label>
                                            <input type="text" class="form-control" name="vehicle_seats"
                                                placeholder="Enter Vehile Seat" required value="{{$vehicles->vehicle_color}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-6 col-md-6 col-xl-6">
                                    <label for="exampleInputEmail1">Vehicle Pic</label>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="vehicle_pic[]">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-success addMore"><i
                                                    class="fa fa-plus"></i>ADD</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-xl-6 vahicleMult">
                                </div>
                                <br>


                            </div>
                            <div class="row">
                                <!-- Image View--->
                                @if($vehicleImage)
                                @foreach ($vehicleImage as $vehicles)
                                    <div class="col-4 col-lg-4 col-sm-4 text-center">
                                        <img src="{{url($vehicles->vehicle_image)}}" style="height : 150px; width:150px">
                                        <br>
                                        <a href="javascritp:void(0)" class="btn btn-sm btn-danger removeImage" data-id="{{$vehicles->id}}"><i class="fa fa-remove"></i></a>
                                    </div>
                                @endforeach
                                @endif
                            </div>

                            <div class="float-right">
                                <button type="submit" name="submit" class="btn btn-success">Save</button>
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
            $('#add-vehicle').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-vehicle")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.vehicle.update') }}",
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
                                    "{{ url('admin/vehicle') }}";
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

            // ADD more Image

            var addButton = $('.addMore');
            var wrapper = ('.vahicleMult');
            $(addButton).on("click", function() {
                var fieldHTML = `
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="vehicle_pic[]">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-danger removeField"><i
                                                    class="fa fa-times"></i>Remove</span>
                                        </div>
                                    </div>
                                `;
                $(wrapper).append(fieldHTML)

            })

            $(wrapper).on('click', '.removeField', function(e){
            e.preventDefault();
            $(this).parent().parent('div').remove();
        });

        });

        // Remove Vehicle Image
        $("body").on("click", ".removeImage", function(e) {
                e.preventDefault();
                let imageId = $(this).data('id');
                let fd = new FormData();
                fd.append('imageId', imageId);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to delete this Image ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.vehicle.image') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1000);
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
