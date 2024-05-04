@extends('admin.layouts.layout')
@section('extra_css')
    ;
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <h2>Dashboard</h2>
                </div>
            </div>
        </div>
        <div class="row column1">

            {{-- @foreach ($catedrivers as $driver)
                <div class="col-md-6 col-lg-3">
                    <div class="full counter_section margin_bottom_30">
                        <div class="couter_icon">
                            <div class="text-center">
                                <img src="{{ $driver->img ? url($driver->img) : '' }}" class="rounded" width="50"
                                    height="50" alt="">
                            </div>
                        </div>
                        <div class="counter_no">
                            <div>
                                <p class="total_no">{{ $driver->count }}</p>
                                <p class="head_couter">{{ $driver->name }} Driver</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/169064404964c52e51d3408.jpg') }}" class="rounded"
                                width="50" height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Motor Bike</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/cng.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Auto CNG</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">AC Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Start AC Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Super Start Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Vip Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Super Vip Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/microbus.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Mirco Bus</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Noah Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Hiace Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/car_icon.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">V-Vip Car</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/ambulance.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Ambulance</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/truck.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Small Truck</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/truck.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Truck</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/truck.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Cargo Truck</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/bus.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Mini Bus</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/bus.png') }}" class="rounded" width="50"
                                height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Luxury Bus</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/chander-car.jpg') }}" class="rounded"
                                width="50" height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Chander Gari</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/helicopter.png') }}" class="rounded"
                                width="50" height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Helicopter</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/hire-driver.png') }}" class="rounded"
                                width="50" height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Hire Driver</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/selfdriving.png') }}" class="rounded"
                                width="50" height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Self Driving Car</p>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div class="text-center">
                            <img src="{{ asset('assets/category/icons/ride-history.png') }}" class="rounded"
                                width="50" height="50" alt="">
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Ride History</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user text-primary"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">New User Register </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user yellow_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">New Driver Register </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user green_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Total Driver </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Total User</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user yellow_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">New Register Manager</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user yellow_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Total Manager</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user yellow_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">New City Agent Register</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-user yellow_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Total City Agent</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Admin Commission</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">City Agent Commission</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Manager Commission</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Total Money</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Super Admin 5%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Agent Office 5%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">App Cost 1.5%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">UD Fund 2%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Offer 1.5%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-dollar red_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">0</p>
                            <p class="head_couter">Tax</p>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
@endsection
@section('extra_js')
@endsection
