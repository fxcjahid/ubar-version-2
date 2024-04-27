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
                                            placeholder="Enter First Name" required value="{{ old('first_name') }}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            placeholder="Enter Last Name" required value="{{ old('last_name') }}">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="phone">Phone </label>
                                            <input type="number" class="form-control" name="phone"
                                                placeholder="Phone Number" required value="{{ old('phone') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="email">Email(Username)</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter E-mail" required value="{{ old('email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password" required value="{{ old('password') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="profile_pic">Profile Pic</label>
                                        <input type="file" class="form-control" name="profile_pic">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-control" name="gender">
                                                <option value="" selected>Choose One</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </div>
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
                                                        {{ $city->id == old('city_id') ? 'selected' : '' }}>
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
                                            <input type="text" class="form-control" name="lat"
                                                placeholder="Enter latitude" required value="{{ old('lat') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="long">longitude</label>
                                            <input type="text" class="form-control" name="long"
                                                placeholder="Enter longitude" required value="{{ old('long') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="speed">Speed</label>
                                            <input type="text" class="form-control" name="speed"
                                                placeholder="Enter speed" required value="{{ old('speed') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="heading">Heading</label>
                                            <input type="text" class="form-control" name="heading"
                                                placeholder="Enter Heading" required value="{{ old('heading') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="app_token">App Token</label>
                                            <input type="text" class="form-control" name="app_token"
                                                placeholder="Enter App Token" required value="{{ old('first_name') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="reset_expires">Reset Expires</label>
                                            <input type="date" class="form-control" name="reset_expires"
                                                placeholder="Enter Reset Expires" required
                                                value="{{ old('reset_expires') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="licence_number">Licence Number</label>
                                            <input type="text" class="form-control" name="licence_number"
                                                placeholder="Enter Licence Number" required
                                                value="{{ old('licence_number') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_owner_mobile">Car Owner Mobile</label>
                                            <input type="text" class="form-control" name="car_owner_mobile"
                                                placeholder="Enter Car Owner Mobile" required
                                                value="{{ old('car_owner_mobile') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="emergency_number">Emergency Number</label>
                                            <input type="text" class="form-control" name="emergency_number"
                                                placeholder="Enter Emergency Number" required
                                                value="{{ old('emergency_number') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_model">Car Model</label>
                                            <input type="text" class="form-control" name="car_model"
                                                placeholder="Enter Car Model" required value="{{ old('car_model') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_cc">Car CC</label>
                                            <input type="text" class="form-control" name="car_cc"
                                                placeholder="Enter Car CC" required value="{{ old('car_cc') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_register_year">Car Register Year</label>
                                            <input type="date" class="form-control" name="car_register_year" required
                                                value="{{ old('car_register_year') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_number">Car Number</label>
                                            <input type="text" class="form-control" name="car_number"
                                                placeholder="Enter Number" required value="{{ old('car_number') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" name="status">
                                                <option value="" selected>Choose One</option>
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive
                                                </option>
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
                                                    <option value="{{ $services->id }}"
                                                        {{ old('services') == $services->id ? 'selected' : '' }}>
                                                        {{ $services->category_name }}</option>
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
                                                @foreach ($types as $type)
                                                    <option value="{{ $type->id }}"
                                                        {{ old('ride_package') == $type->id ? 'selected' : '' }}>
                                                        {{ $type->t_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" class="form-control" name="address" />
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="gps_tracking">GPS Tracking</label>
                                        <select id="gps_tracking" class="form-control" name="gps_tracking" required>
                                            <option value="no">No</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="driver-docoment">
                                <div class="heading1">
                                    <h2>Driver Documents</h2>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="driver_licence_front_pic">Licence Font Photo</label>
                                            <input id="driver_licence_front_pic" type="file" class="form-control"
                                                name="driver_licence_front_pic">
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="driver_licence_back_pic">Licence Back Photo</label>
                                            <input id="driver_licence_back_pic" type="file" class="form-control"
                                                name="driver_licence_back_pic">
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="car_pic">Car Photo</label>
                                                <input id="car_pic" type="file" class="form-control"
                                                    name="car_pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="electricity_bill_pic">Electricity Bill Photo</label>
                                                <input id="electricity_bill_pic" type="file" class="form-control"
                                                    name="electricity_bill_pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="bank_check_book_pic">Bank Check Book Photo</label>
                                                <input id="bank_check_book_pic" type="file" class="form-control"
                                                    name="bank_check_book_pic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="car_front_side_pic">Car Font Side Photo</label>
                                            <input id="car_front_side_pic" type="file" class="form-control"
                                                name="car_front_side_pic">
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="car_back_side_pic">Car Back Side Photo</label>
                                            <input id="car_back_side_pic" type="file" class="form-control"
                                                name="car_back_side_pic">
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="car_registration_pic">Car Registration Photo</label>
                                            <input id="car_registration_pic" type="file" class="form-control"
                                                name="car_registration_pic">
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="car_tax_token_licence">Car Tax Token Licence Photo</label>
                                            <input id="car_tax_token_licence" type="file" class="form-control"
                                                name="car_tax_token_licence">
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="car_fitness_licence">Car Fitness Licence Photo</label>
                                            <input id="car_fitness_licence" type="file" class="form-control"
                                                name="car_fitness_licence">
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="car_insurance_licence">Car Insurance Licence Photo</label>
                                            <input id="car_insurance_licence" type="file" class="form-control"
                                                name="car_insurance_licence">
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="car_route_permit_licence">Car Route Permit Licence Photo</label>
                                            <input id="car_route_permit_licence" type="file" class="form-control"
                                                name="car_route_permit_licence">
                                        </div>
                                    </div>

                                    <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                            <label for="add_extra_pic">Extra Photo</label>
                                            <input id="add_extra_pic" type="file" class="form-control"
                                                name="add_extra_pic">
                                        </div>
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
