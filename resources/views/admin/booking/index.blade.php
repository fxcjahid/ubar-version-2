@extends('admin.layouts.layout')
@section('extra_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.css">
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Booking List</h2>
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
                            <h2>Booking List</h2>
                        </div>
                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table class="table display nowrap" id="example">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Username</th>
                                        <th>Driver Name</th>
                                        <th>Mobile Number</th>
                                        <th>Pickup location</th>
                                        <th>Drop Location</th>
                                        <th>Destination</th>
                                        <th>Vehicle</th>
                                        <th>Payment Type</th>
                                        <th>Per Km</th>
                                        <th>Per Day</th>
                                        <th>Per Hour</th>
                                        <th>Per Week</th>
                                        <th>Per Month</th>
                                        <th>Per Holiday</th>
                                        <th>Total Fare</th>
                                        <th>Total Destination</th>
                                        <th>Booking Status</th>
                                        <th>Booking Type</th>
                                        <th>Pickup date</th>
                                        <th>Ride Type</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Return date</th>
                                        <th>Booking Hour</th>
                                        <th>Total Day</th>
                                        <th>Vehicle</th>
                                        <th>Package</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking as $item)
                                        <tr>
                                            <td>{{ $item->invoice_id ?? 'N/A' }}</td>
                                            <td>{{ $item->user?->name }}</td>
                                            <td>{{ $item->driver?->name }}</td>
                                            <td>{{ $item->driver?->phone }}</td>
                                            <td>{{ $item->pickup_location }}</td>
                                            <td>{{ $item->drop_location ?? 'N/A' }}</td>
                                            <td>{{ $item->destination ?? 'N/A' }}</td>
                                            <td>{{ $item->vehicle->vehicle_brand ?? 'N/A' }}</td>
                                            <td>{{ $item->payment_type ?? 'N/A' }}</td>
                                            <td>{{ $item->per_km ?? 'N/A' }}</td>
                                            <td>{{ $item->per_day ?? 'N/A' }}</td>
                                            <td>{{ $item->per_hour ?? 'N/A' }}</td>
                                            <td>{{ $item->per_week ?? 'N/A' }}</td>
                                            <td>{{ $item->per_month ?? 'N/A' }}</td>
                                            <td>{{ $item->per_holiday ?? 'N/A' }}</td>
                                            <td>{{ $item->total_fare ?? 'N/A' }}</td>
                                            <td>{{ $item->total_distance ?? 'N/A' }}</td>
                                            <td>{{ $item->booking_status ?? 'N/A' }}</td>
                                            <td>{{ $item->booking_type ?? 'N/A' }}</td>
                                            <td>{{ $item->pickup_date . ' / ' . $item->pickup_time }}</td>
                                            <td>{{ $item->ride_type ?? 'N/A' }}</td>
                                            <td>{{ $item->ride_start_time ?? 'N/A' }}</td>
                                            <td>{{ $item->ride_end_time ?? 'N/A' }}</td>
                                            <td>{{ $item->return_date . ' / ' . $item->return_time }}</td>
                                            <td>{{ $item->total_booking_hour ?? 'N/A' }}</td>
                                            <td>{{ $item->total_day ?? 'N/A' }}</td>
                                            <td>{{ $item->category?->category_name ?? 'N/A' }}</td>
                                            <td>{{ $item->type_id ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.booking.invoice', ['id' => $item->invoice_id]) }}"
                                                    target="_blank" title="view invoice" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-file txt-white"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('extra_js')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#example');
    </script>
@endsection
@endsection
