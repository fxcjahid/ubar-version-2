@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.driver') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Edit Driver</h2></span>
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
                            <h2>Edit Driver</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form action="{{ route('admin.driver.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('admin.include.message')
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            placeholder="Enter First Name" value="{{ old('first_name', $user->first_name) }}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            placeholder="Enter Last Name" value="{{ old('last_name', $user->last_name) }}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="phone">Phone </label>
                                            <input type="number" class="form-control" name="phone"
                                                placeholder="Phone Number" value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="email">Email(Username)</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter E-mail" value="{{ old('email', $user->email) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password" value="{{ old('password') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="profile_pic">Profile Pic</label>
                                        <input type="file" class="form-control" name="profile_pic" onchange="preview();">

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
                                                    <option value="{{ $city->id }}"
                                                        {{ $city->id == old('city_id', $user->city_id) ? 'selected' : '' }}>
                                                        {{ $city->city }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="lat">latitude</label>
                                            <input type="text" class="form-control" name="lat" value="{{ old('lat', $user->lat) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="long">longitude</label>
                                            <input type="text" class="form-control" name="long"
                                                placeholder="Enter longitude" value="{{ old('long', $user->long) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="speed">Speed</label>
                                            <input type="text" class="form-control" name="speed"
                                                placeholder="Enter speed" value="{{ old('speed', $user->speed) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="heading">Heading</label>
                                            <input type="text" class="form-control" name="heading"
                                                placeholder="Enter Heading" value="{{ old('heading', $user->heading) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="app_token">App Token</label>
                                            <input type="text" class="form-control" name="app_token"
                                                placeholder="Enter App Token"  value="{{ old('app_token', $user->app_token) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="reset_expires">Reset Expires</label>
                                            <input type="date" class="form-control" name="reset_expires"
                                                placeholder="Enter Reset Expires"
                                                value="{{ old('reset_expires', $user->reset_expires) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="licence_number">Licence Number</label>
                                            <input type="text" class="form-control" name="licence_number"
                                                placeholder="Enter Licence Number"
                                                value="{{ old('licence_number', $user->licence_number) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_owner_mobile">Car Owner Mobile</label>
                                            <input type="text" class="form-control" name="car_owner_mobile"
                                                placeholder="Enter Car Owner Mobile"
                                                value="{{ old('car_owner_mobile', $user->car_owner_mobile) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="emergency_number">Emergency Number</label>
                                            <input type="text" class="form-control" name="emergency_number"
                                                placeholder="Enter Emergency Number"
                                                value="{{ old('emergency_number', $user->emergency_number) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_model">Car Model</label>
                                            <input type="text" class="form-control" name="car_model"
                                                placeholder="Enter Car Model" value="{{ old('car_model', $user->car_model) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_cc">Car CC</label>
                                            <input type="text" class="form-control" name="car_cc"
                                                placeholder="Enter Car CC" value="{{ old('car_cc', $user->car_cc) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_register_year">Car Register Year</label>
                                            <input type="date" class="form-control" name="car_register_year"
                                                value="{{ old('car_register_year', $user->car_register_year) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_number">Car Number</label>
                                            <input type="text" class="form-control" name="car_number"
                                                placeholder="Enter Number" value="{{ old('car_number', $user->car_number) }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="" selected>Choose One</option>
                                                <option value="1" {{ old('status', $user->status) == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ old('status', $user->status) == 0 ? 'selected' : '' }}>Inactive
                                                </option>
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
                                                <option value="1" {{ old('gender', $user->gender) == 1 ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="2" {{ old('gender', $user->gender) == 2 ? 'selected' : '' }}>Female
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="ride_service">Ride Service</label>
                                            <select class="form-control" name="ride_service">
                                                <option value="" selected>Choose One</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="ride_package">Ride Package</label>
                                            <select class="form-control" name="ride_package">
                                                <option value="" selected>Choose One</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <textarea type="text" class="form-control" name="address" cols="4" rows="4">{{ old('address', $user->address) }}</textarea>
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
    <script>

    </script>
@endsection
@endsection
