@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <a href="{{ route('admin.driver') }}">
                        <i class="fa fa-arrow-left black"></i> Back
                    </a>
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
                            <h2>Driver Documents</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form action="{{ route('admin.driver.update.docs', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @include('admin.include.message')
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="driver_licence_front_pic">Licence Font Photo</label>
                                        <input id="driver_licence_front_pic" type="file" class="form-control" name="driver_licence_front_pic">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="driver_licence_back_pic">Licence Back Photo</label>
                                        <input id="driver_licence_back_pic" type="file" class="form-control" name="driver_licence_back_pic">
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="car_pic">Car Photo</label>
                                            <input id="car_pic" type="file" class="form-control" name="car_pic">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="electricity_bill_pic">Electricity Bill Photo</label>
                                            <input id="electricity_bill_pic" type="file" class="form-control" name="electricity_bill_pic">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="bank_check_book_pic">Bank Check Book Photo</label>
                                            <input id="bank_check_book_pic" type="file" class="form-control" name="bank_check_book_pic">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="car_front_side_pic">Car Font Side Photo</label>
                                        <input id="car_front_side_pic" type="file" class="form-control" name="car_front_side_pic">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="car_back_side_pic">Car Back Side Photo</label>
                                        <input id="car_back_side_pic" type="file" class="form-control" name="car_back_side_pic">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="car_registration_pic">Car Registration Photo</label>
                                        <input id="car_registration_pic" type="file" class="form-control" name="car_registration_pic">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="car_tax_token_licence">Car Tax Token Licence Photo</label>
                                        <input id="car_tax_token_licence" type="file" class="form-control" name="car_tax_token_licence">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="car_fitness_licence">Car Fitness Licence Photo</label>
                                        <input id="car_fitness_licence" type="file" class="form-control" name="car_fitness_licence">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="car_insurance_licence">Car Insurance Licence Photo</label>
                                        <input id="car_insurance_licence" type="file" class="form-control" name="car_insurance_licence">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="car_route_permit_licence">Car Route Permit Licence Photo</label>
                                        <input id="car_route_permit_licence" type="file" class="form-control" name="car_route_permit_licence">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="add_extra_pic">Extra Photo</label>
                                        <input id="add_extra_pic" type="file" class="form-control" name="add_extra_pic">
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
