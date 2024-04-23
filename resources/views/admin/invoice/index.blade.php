@extends('admin.layouts.layout')
@section('extra_css')
    <style>
        #sidebar,
        .topbar,
        .footer {
            display: none !important;
        }

        #content {
            padding: 60px;
        }
    </style>
@endsection
@section('section')
    <div class="container-fluid bookingInvoice">
        <div class="card">
            <div class="card-header">
                <div class="row float-left">
                    <h3>Invoice ID: {!! $data->invoice_id !!}</h3>
                </div>
                <div class="row float-right">
                    <a href="{{ route('admin.booking_list') }}" class="backToBookingListLink">
                        Back to Booking List
                    </a>
                </div>
            </div>
            <div class="card-body" id="print_demant_invoice">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="container-fluid">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Invoice Id</td>
                                        <td>{!! $data->invoice_id !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Issue Date</td>
                                        <td>{{ $data->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Booking Status</td>
                                        <td>{!! $data->booking_status !!}</td>
                                    </tr>
                                    <tr>
                                        <td>OTP</td>
                                        <td>{!! $data->otp !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Car Number</td>
                                        <td>{!! $data->user->car_number !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Driver Id Number</td>
                                        <td>{!! $data->driver_id !!}</td>
                                    </tr>
                                    <tr>
                                        <td>User Id Number</td>
                                        <td>{!! $data->user_id !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Pickup Location</td>
                                        <td>{{ $data->pickup_location }}</td>
                                    </tr>
                                    <tr>
                                        <td>Drop Location</td>
                                        <td>{{ $data->drop_location }}</td>
                                    </tr>
                                    <tr>
                                        <td>Ride Start Time</td>
                                        <td>{{ $data->ride_start_time }}</td>
                                    </tr>
                                    <tr>
                                        <td>Ride End Time</td>
                                        <td>{{ $data->ride_end_time }}</td>
                                    </tr>
                                    <tr>
                                        <td>App Service Fees</td>
                                        <td>{{ round($data->total_fare * (1.5 / 100), 2) }} Taka</td>
                                    </tr>
                                    <tr>
                                        <td>Base Fees</td>
                                        <td>50.00 Taka</td>
                                    </tr>
                                    <tr>
                                        <td>Ride Per/KM</td>
                                        <td>{{ $data->ride_per_km }}</td>
                                    </tr>
                                    <tr>
                                        <td>Ride Distance Fare</td>
                                        <td>{{ $data->ride_distance_fare }}</td>
                                    </tr>
                                    <tr>
                                        <td>Waiting Charge Minutes</td>
                                        <td>03.00 Taka</td>
                                    </tr>
                                    <tr>
                                        <td>Waiting Charge for 1 Hours</td>
                                        <td>180.00 Taka</td>
                                    </tr>
                                    <tr>
                                        <td>Vat Free Ride Bill</td>
                                        <td>2.00%</td>
                                    </tr>
                                    <tr>
                                        <td>Ride Cancelling Fees</td>
                                        <td>50.00 Taka</td>
                                    </tr>
                                    <tr>
                                        <td>User Driver Help Fund</td>
                                        <td>10.00 Taka</td>
                                    </tr>
                                    <tr>
                                        <td><b>Total Bill</b></td>
                                        <td><b>{{ $data->total_fare }} Taka</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
