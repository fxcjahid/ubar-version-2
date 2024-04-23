@extends('admin.layouts.layout')
@section('extra_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.driver') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Add Driver</h2></span>
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
                            <h2>Create Driver</h2>
                        </div>
                    </div>
                    @include('admin.include.message')
                    <div class="padding_infor_info">
                        <form action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            placeholder="Enter First Name" required value="{{old('first_name')}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            placeholder="Enter Last Name" required value="{{old('last_name')}}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="phone">Phone </label>
                                            <input type="number" class="form-control" name="phone"
                                                placeholder="Phone Number" required value="{{old('phone')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="email">Email(Username)</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter E-mail" required value="{{old('email')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password" required value="{{old('password')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="profile_pic">Profile Pic</label>
                                        <input type="file" class="form-control" name="profile_pic"
                                            onchange="preview();">

                                        <img id="output" style="width: 50px; height:50px" class="rounded" />
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="city_id">City</label>
                                            <select class="form-control" name="city_id">
                                                <option value="" selected>Choose One</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{$city->id}}" {{ $city->id == old('city_id') ? 'selected' : ''}}>{{$city->city}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="lat">latitude</label>
                                            <input type="text" class="form-control" name="lat"
                                                placeholder="Enter latitude" required value="{{old('lat')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="long">longitude</label>
                                            <input type="text" class="form-control" name="long"
                                                placeholder="Enter longitude" required value="{{old('long')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="speed">Speed</label>
                                            <input type="text" class="form-control" name="speed"
                                                placeholder="Enter speed" required value="{{old('speed')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="heading">Heading</label>
                                            <input type="text" class="form-control" name="heading"
                                                placeholder="Enter Heading" required value="{{old('heading')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="app_token">App Token</label>
                                            <input type="text" class="form-control" name="app_token"
                                                placeholder="Enter App Token" required value="{{old('first_name')}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="reset_expires">Reset Expires</label>
                                            <input type="date" class="form-control" name="reset_expires"
                                                placeholder="Enter Reset Expires" required value="{{old('reset_expires')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="licence_number">Licence Number</label>
                                            <input type="text" class="form-control" name="licence_number"
                                                placeholder="Enter Licence Number" required value="{{old('licence_number')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_owner_mobile">Car Owner Mobile</label>
                                            <input type="text" class="form-control" name="car_owner_mobile"
                                                placeholder="Enter Car Owner Mobile" required value="{{old('car_owner_mobile')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="emergency_number">Emergency Number</label>
                                            <input type="text" class="form-control" name="emergency_number"
                                                placeholder="Enter Emergency Number" required value="{{old('emergency_number')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_model">Car Model</label>
                                            <input type="text" class="form-control" name="car_model"
                                                placeholder="Enter Car Model" required value="{{old('car_model')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_cc">Car CC</label>
                                            <input type="text" class="form-control" name="car_cc"
                                                placeholder="Enter Car CC" required value="{{old('car_cc')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_register_year">Car Register Year</label>
                                            <input type="date" class="form-control" name="car_register_year" required value="{{old('car_register_year')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_number">Car Number</label>
                                            <input type="text" class="form-control" name="car_number"
                                                placeholder="Enter Number" required value="{{old('car_number')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="" selected>Choose One</option>
                                                <option value="1" {{ old('status') == 1 ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{ old('status') == 0 ? 'selected' : ''}}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-control" name="gender">
                                                <option value="" selected>Choose One</option>
                                                <option value="1" {{ old('gender') == 1 ? 'selected' : ''}}>Male</option>
                                                <option value="2" {{ old('gender') == 2 ? 'selected' : ''}}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="ride_service">Ride Service</label>
                                            <select class="form-control" name="services">
                                                <option value="" selected>Choose One</option>
                                                @foreach ($services as $services)
                                                    <option value="{{ $services->id }}" {{ old('services') == $services->id ? 'selected' : ''}}>{{ $services->category_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="ride_package">Ride Package</label>
                                            <select name="ride_package" class="form-control">
                                                <option value="" selected>Choose One</option>
                                                {{-- @foreach ($types as $type)
                                                    <option value="{{ $type->id }}" {{ old('ride_package') == $type->id ? 'selected' : ''}}>{{ $type->t_name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <textarea type="text" class="form-control" name="address" cols="4" rows="4">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="float-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('extra_js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@endsection
