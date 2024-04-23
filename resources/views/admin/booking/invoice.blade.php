@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="row float-left">
                <a href="{{ route('admin.booking_list') }}">
                    <button type="button" class="btn btn-primary btn-rounded btn-icon">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </a>
            </div>
        </div>
        <div class="card-body" id="print_demant_invoice">

            <div class="row">
                <div class="col-sm-12">

                </div>
                <div class="col-sm-5 mt-5">
                    <div class="container-fluid">
                        <p><b>Invoice Id : </b>
                        <p><b>Issue Date : </b><b></b></p>
                        <p><b>Car Number : </b><b></b></p>
                        <p><b>Driver Id Number : </b><b></b></p>
                        <p><b>User Id Number: </b><b></b></p>
                        <p><b>Ride Start Time : </b><b></b></p>
                        <p><b>Ride End Time : </b><b></b></p>
                        <p><b>App SerVice Fees : </b><b></b></p>
                        <p><b>Base Fees : </b><b></b></p>
                        <p><b>Ride Per/KM : </b><b></b></p>
                        <p><b>Ride Distance Fare : </b><b></b></p>
                        <p><b>Waiting Charge Minutes : </b><b></b></p>
                        <p><b>Waiting Charge Cost30 Mintues : </b><b></b></p>
                        <p><b>Tax Free Ride Bill : </b><b></b></p>
                        <p><b>Vat Free Ride Bill : </b><b></b></p>
                        <p><b>Ride Cancelling Fees : </b><b></b></p>
                        <p><b>User Driver Help Fund : </b><b></b></p>
                        <p><b>Car Name : </b><b></b></p>
                        <p><b>Car Number : </b><b></b></p>
                    </div>
                </div>
                <div class="col-sm-5 mt-5">
                    <div class="container-fluid">
                        <p><b>{{$dataArray['invoice_id']}}</b></p>
                        <p><b>{{date('d-m-Y' , strtotime($dataArray['Issue_date']))}}</b></p>
                        <p><b>{{date('H:i A' ,strtotime($dataArray['time']))}}</b></p>
                        <p><b>{{$dataArray['car_number']}}</b></p>
                        <p><b>{{$dataArray['driver_id_number']}}</b></p>
                        <p><b>{{$dataArray['user_id_number']}}</b></p>
                        <p><b>{{date('d-m-Y' , strtotime($dataArray['ride_start_time']))}}</b></p>
                        <p><b>{{date('H:i A' , strtotime($dataArray['ride_end_time']))}}</b></p>
                        <p><b>{{$dataArray['app_service_fee']}}</b></p>
                        <p><b>{{$dataArray['base_fare']}}</b></p>
                        <p><b>{{$dataArray['ride_per_km']}}</b></p>
                        <p><b>{{$dataArray['ride_distance_fare']}}</b></p>
                        <p><b>{{$dataArray['waiting_charge_minutes']}}</b></p>
                        <p><b>{{$dataArray['waiting_charge_cost30min']}}</b></p>
                        <p><b>{{$dataArray['tax_free_ride_bill']}}</b></p>
                        <p><b>{{$dataArray['vat_free_ride_bill']}}</b></p>
                        <p><b>{{$dataArray['ride_cancelling_fee']}}</b></p>
                        <p><b>{{$dataArray['user_driver_help_fund']}}</b></p>
                        <p><b>{{$dataArray['car_name']}}</b></p>
                        <p><b>{{$dataArray['car_number']}}</b></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button onclick="printDiv('print_demant_invoice')" type="button" class="btn btn-primary btn-sm d-print-none"><i class="dripicons-print"></i> Print</button>
        <button type="button" class="close d-print-none float-left" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@section('extra_js')
<script>
    $(function() {
        // Process for load the table of Transfer stock

    });

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endsection
@endsection
