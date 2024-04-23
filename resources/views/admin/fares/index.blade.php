@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Fare List</h2>
                    <div class="float-right ">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fareModal">
                            Add Fare
                        </button>
                    </div>
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
                            <h2>Fare List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="fare-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ride TYpe</th>
                                        <th>Vehicle Category</th>
                                        <th>Fare Category</th>
                                        <th>Per KM's Fare</th>
                                        <th>Per Hour Fare</th>
                                        <th>Per Day Fare</th>
                                        <th>Per Week Fare</th>
                                        <th>Per Month Fare</th>
                                        <th>Holiday Fare</th>
                                        <th>Per Holiday Fare</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="fareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Fares</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="add-fare" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="ride-type-category">Ride Type Category</label>
                                                <select id="ride-type-category" name="type" class="form-control"
                                                    required>
                                                    <option value="">Select Ride Type</option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->t_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="category">Vehicle Category</label>
                                                <select id="category" name="category" class="form-control" required>
                                                    <option value="">Select Category</option>
                                                    @foreach ($category as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="fare-category-section" class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="fare-category">Fare Category</label>
                                                <select id="fare-category" name="fare_category" class="form-control">
                                                    <option value="">Select Fare Category</option>
                                                    @foreach ($fare_category as $fare_cat)
                                                        <option value="{{ $fare_cat->id }}">{{ $fare_cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 d-none" id="fare-category-time">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="fare-category-officeTime">Office Time</label>
                                                        <input id="fare-category-officeTime" type="number"
                                                            class="form-control" name="officeTime"
                                                            placeholder="Office Time">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="fare-category-lunchHours">Lunch Hours</label>
                                                        <input id="fare-category-lunchHours" type="number"
                                                            class="form-control" name="lunchHours"
                                                            placeholder="Lunch Hours">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="fare-category-eveningHours">Evening Hours</label>
                                                        <input id="fare-category-eveningHours" type="number"
                                                            class="form-control" name="eveningHours"
                                                            placeholder="Evening Hours">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="fare-category-nightHours">Night Hours</label>
                                                        <input id="fare-category-nightHours" type="number"
                                                            class="form-control" name="nightHours"
                                                            placeholder="Night Hours">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="fare-category-mindNight">Mind Night</label>
                                                        <input id="fare-category-mindNight" type="number"
                                                            class="form-control" name="mindNight"
                                                            placeholder="Mind Night">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label for="fare-category-morning">Morning</label>
                                                        <input id="fare-category-morning" type="number"
                                                            class="form-control" name="morningTime"
                                                            placeholder="Morning">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="per-km-fare">Per KM's Fare</label>
                                                <input id="per-km-fare" type="number" class="form-control"
                                                    name="km" placeholder="Enter Per KM's Fare" required>
                                            </div>
                                        </div>

                                        <div id="per-hour-fare-section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="per-hour-fare">Per Hours Fare</label>
                                                <input id="per-hour-fare" type="number" class="form-control"
                                                    name="per_hour_fare" placeholder="Enter Per Hour Fare" required>
                                            </div>
                                        </div>

                                        <div id="per-day-fare-section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="per-day-fare">Per Day Fare</label>
                                                <input id="per-day-fare" type="number" class="form-control"
                                                    name="per_day_fare" placeholder="Enter Per Day Fare" required>
                                            </div>
                                        </div>

                                        <div id="per-week-fare-section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="per-week-fare">Per Week Fare</label>
                                                <input id="per-week-fare" type="number" class="form-control"
                                                    name="per_week_fare" placeholder="Enter Per Week Fare" required>
                                            </div>
                                        </div>

                                        <div id="per-month-fare-section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="per-month-fare">Per Month Fare</label>
                                                <input id="per-month-fare" type="number" class="form-control"
                                                    name="per_month_fare" placeholder="Enter Per Month Fare" required>
                                            </div>
                                        </div>

                                        <div id="holiday-fare-section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="holiday-fare">Holiday Fare</label>
                                                <select id="holiday-fare" name="holiday_fare" class="form-control">
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="per-holiday-fare-section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="per-holiday-fare">Per Holiday Fare</label>
                                                <input id="per-holiday-fare" type="number" class="form-control"
                                                    name="per_holiday_fare" placeholder="Enter Per Holiday Fare" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Edit City Modal-->
                <div class="modal fade" id="editFareModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Fare</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="edit-fare" method="POST">
                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="edit_ride_type">Ride TypeCategory</label>
                                                <select name="edit_type" class="form-control" required
                                                    id="edit_ride_type">
                                                    <option value="">Select Ride Type</option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->t_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="edit_category">Category</label>
                                                <select name="edit_category" class="form-control" required
                                                    id="edit_category">
                                                    <option value="">Select Category</option>
                                                    @foreach ($category as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div id="edit_fare_category_section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="edit_fare_category">Fare Category</label>
                                                <select name="edit_fare_category" class="form-control" required
                                                    id="edit_fare_category">
                                                    <option value="">Select Fare Category</option>
                                                    @foreach ($fare_category as $fare_cat)
                                                        <option value="{{ $fare_cat->id }}">{{ $fare_cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="edit_km">Per KM's Fare</label>
                                                <input type="number" class="form-control" name="edit_km"
                                                    placeholder="Enter Per KM's Fare" required id="edit_km">
                                            </div>
                                        </div>
                                        <div id="edit_per_hour_fare_section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="edit_per_hour_fare">Per Hours Fare</label>
                                                <input type="number" class="form-control" name="edit_per_hour_fare"
                                                    placeholder="Enter Per Hour Fare" id="edit_per_hour_fare" required>
                                            </div>
                                        </div>

                                        <div id="edit_per_day_fare_section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="edit_per_day_fare">Per Day Fare</label>
                                                <input type="number" class="form-control" name="edit_per_day_fare"
                                                    placeholder="Enter Per Day Fare" id="edit_per_day_fare" required>
                                            </div>
                                        </div>

                                        <div id="edit_per_week_fare_section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="edit_per_week_fare">Per Week Fare</label>
                                                <input type="number" class="form-control" name="edit_per_week_fare"
                                                    placeholder="Enter Per Week Fare" id="edit_per_week_fare" required>
                                            </div>
                                        </div>

                                        <div id="edit_per_month_fare_section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="edit_per_month_fare">Per Month Fare</label>
                                                <input type="number" class="form-control" name="edit_per_month_fare"
                                                    placeholder="Enter Per Month Fare" id="edit_per_month_fare" required>
                                            </div>
                                        </div>

                                        <div id="edit_holiday_fare_section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="edit_holiday_fare">Holiday Fare</label>
                                                <select id="edit_holiday_fare" name="edit_holiday_fare"
                                                    class="form-control">
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="edit_per_holiday_fare_section"
                                            class="col-12 col-sm-12 col-md-12 col-xl-12 d-none">
                                            <div class="form-group">
                                                <label for="edit_per_holiday_fare">Per Holiday Fare</label>
                                                <input type="number" class="form-control" name="edit_per_holiday_fare"
                                                    placeholder="Enter Per Day Fare" id="edit_per_holiday_fare" required>
                                            </div>
                                        </div>
                                        <input type="hidden" name="fareId" id="fareId">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('extra_js')
    <script>
        $(function() {
            $.fn.tableload = function() {

                $('#fare-data').dataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "bDestroy": true,
                    'checkboxes': {
                        'selectRow': true
                    },
                    "ajax": {
                        url: "{{ route('admin.fare.list_ajax') }}",
                        "type": "GET",
                        "data": function(d) {
                            d._token = "{{ csrf_token() }}";
                        },
                        dataFilter: function(data) {
                            var json = jQuery.parseJSON(data);
                            json.recordsTotal = json.recordsTotal;
                            json.recordsFiltered = json.recordsFiltered;
                            json.data = json.data;
                            return JSON.stringify(json); // return JSON string
                        }
                    },
                    "order": [
                        [0, 'desc']
                    ],
                    "columns": [{
                            "targets": 0,
                            "name": "id",
                            'searchable': false,
                            'orderable': true
                        },
                        {
                            "targets": 1,
                            "name": "ride_type",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 2,
                            "name": "category_name",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 3,
                            "name": "fare_category",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 4,
                            "name": "km",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 5,
                            "name": "per_hour_fare",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "per_day_fare",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "per_week_fare",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "per_month_fare",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "holiday_fare",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "per_holiday_fare",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 7,
                            "name": "status",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 8,
                            "name": "action",
                            'searchable': false,
                            'orderable': false
                        },
                    ]
                });
            }
            $.fn.tableload();

            // Add Fare process
            $('#add-fare').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-fare")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.fare.store') }}",
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
                            $('#add-fare')[0].reset();

                            $('#per-hour-fare-section').addClass('d-none');
                            $('#per-day-fare-section').addClass('d-none');
                            $('#per-week-fare-section').addClass('d-none');
                            $('#per-month-fare-section').addClass('d-none');
                            $('#holiday-fare-section').addClass('d-none');
                            $('#per-holiday-fare-section').addClass('d-none');

                            $("#fareModal").modal("toggle");
                            $('#fare-data').DataTable().ajax.reload(null, false);
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

            //Remove Category process
            $("body").on("click", ".remove-fare", function(e) {
                e.preventDefault();
                let fareId = $(this).data('id');
                let fd = new FormData();
                fd.append('fareId', fareId);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to remove fare ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.fare.destroy') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#fare-data').DataTable().ajax.reload(null,
                                            false);
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

            // Fare Status Change
            $("body").on("click", ".updateFare", function(e) {
                e.preventDefault();
                let fareId = $(this).data('id');
                let status = $(this).data('status');
                let fd = new FormData();
                fd.append('fareId', fareId);
                fd.append('status', status);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to change status ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.fare.status_change') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#fare-data').DataTable().ajax.reload(null,
                                            false);
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

            // Edit City
            $("body").on("click", ".editFare", function() {
                var category = $(this).data('category');
                var category_name = $(this).data('category_name');
                var type = $(this).data('type');
                var t_name = $(this).data('t_name');
                var fare_category = $(this).data('fare_category');
                var fare_category_name = $(this).data('fare_category_name');
                var km = $(this).data('km');
                var fareId = $(this).data('id');
                var per_day_fare = $(this).data('per_day_fare');
                var per_hour_fare = $(this).data('per_hour_fare');
                var per_week_fare = $(this).data('per_week_fare');
                var per_month_fare = $(this).data('per_month_fare');
                var holiday_fare = $(this).data('holiday_fare');
                var per_holiday_fare = $(this).data('per_holiday_fare');

                $('#edit_ride_type').val(type);

                var ride_type_category = $('#edit_ride_type option:selected').html();

                if (ride_type_category == 'Schedule Car' || ride_type_category == 'Intercity' ||
                    ride_type_category == 'Rental Car' || ride_type_category == 'Chander Pahar Car' ||
                    ride_type_category == 'Ambulance' || ride_type_category == 'Truck' ||
                    ride_type_category == 'Bus' || ride_type_category == 'Helicopter' ||
                    ride_type_category == 'Hire Driver' || ride_type_category == 'Self Driving Car') {
                    $('#edit_fare_category_section').removeClass('d-none');
                    $('#edit_per_day_fare_section').removeClass('d-none');
                    $('#edit_per_week_fare_section').removeClass('d-none');
                    $('#edit_per_month_fare_section').removeClass('d-none');
                    $('#edit_holiday_fare_section').removeClass('d-none');
                    $('#edit_per_holiday_fare_section').removeClass('d-none');
                } else {
                    $('#edit_fare_category_section').addClass('d-none');
                    $('#edit_per_day_fare_section').addClass('d-none');
                    $('#edit_per_week_fare_section').addClass('d-none');
                    $('#edit_per_month_fare_section').addClass('d-none');
                    $('#edit_holiday_fare_section').addClass('d-none');
                    $('#edit_per_holiday_fare_section').addClass('d-none');
                }

                if (ride_type_category == 'Schedule Car' || ride_type_category == 'Hourly Car' ||
                    ride_type_category == 'Intercity' || ride_type_category == 'Rental Car' ||
                    ride_type_category == 'Chander Pahar Car' || ride_type_category == 'Ambulance' ||
                    ride_type_category == 'Truck' || ride_type_category == 'Bus' || ride_type_category ==
                    'Helicopter' || ride_type_category == 'Hire Driver' || ride_type_category ==
                    'Self Driving Car') {
                    $('#edit_per_hour_fare_section').removeClass('d-none');
                } else {
                    $('#edit_per_hour_fare_section').addClass('d-none')
                }


                $('#edit_category').val(category);
                $('#edit_fare_category').val(fare_category);
                $("#edit_km").val(km);
                $("#edit_per_day_fare").val(per_day_fare);
                $("#edit_per_hour_fare").val(per_hour_fare);
                $("#edit_per_week_fare").val(per_week_fare);
                $("#edit_per_month_fare").val(per_month_fare);
                $("#edit_holiday_fare").val(holiday_fare);
                $("#edit_per_holiday_fare").val(per_holiday_fare);
                $("#fareId").val(fareId);
                $("#editFareModal").modal("toggle");
            })

            // Update City
            $('#edit-fare').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#edit-fare")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.fare.update') }}",
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
                            $('#edit-fare')[0].reset();
                            $("#editFareModal").modal("toggle");
                            $('#fare-data').DataTable().ajax.reload(null, false);
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

            $('#fare-category').on('change', function(e) {

                var selectedValue = $(this).val();

                if (selectedValue != "") {
                    $('#fare-category-time').removeClass('d-none');
                } else {
                    $('#fare-category-time').addClass('d-none');
                }

            });

            $('#ride-type-category').on('change', function(e) {
                var ride_type_category = $('#ride-type-category option:selected').html();

                if (ride_type_category == 'Schedule Car' || ride_type_category == 'Intercity' ||
                    ride_type_category == 'Rental Car' || ride_type_category == 'Chander Pahar Car' ||
                    ride_type_category == 'Ambulance' || ride_type_category == 'Truck' ||
                    ride_type_category == 'Bus' || ride_type_category == 'Helicopter' ||
                    ride_type_category == 'Hire Driver' || ride_type_category == 'Self Driving Car') {

                    $('#per-day-fare-section').removeClass('d-none');
                    $('#per-week-fare-section').removeClass('d-none');
                    $('#per-month-fare-section').removeClass('d-none');
                    $('#holiday-fare-section').removeClass('d-none');
                    $('#per-holiday-fare-section').removeClass('d-none');
                } else {

                    $('#per-day-fare-section').addClass('d-none');
                    $('#per-week-fare-section').addClass('d-none');
                    $('#per-month-fare-section').addClass('d-none');
                    $('#holiday-fare-section').addClass('d-none');
                    $('#per-holiday-fare-section').addClass('d-none');
                }

                if (ride_type_category == 'Schedule Car' || ride_type_category == 'Hourly Car' ||
                    ride_type_category == 'Intercity' || ride_type_category == 'Rental Car' ||
                    ride_type_category == 'Chander Pahar Car' || ride_type_category == 'Ambulance' ||
                    ride_type_category == 'Truck' || ride_type_category == 'Bus' || ride_type_category ==
                    'Helicopter' || ride_type_category == 'Hire Driver' || ride_type_category ==
                    'Self Driving Car') {
                    $('#per-hour-fare-section').removeClass('d-none');
                } else {
                    $('#per-hour-fare-section').addClass('d-none')
                }

            })

            $('#edit_ride_type').on('change', function(e) {
                var ride_type_category = $('#edit_ride_type option:selected').html();

                if (ride_type_category == 'Schedule Car' || ride_type_category == 'Intercity' ||
                    ride_type_category == 'Rental Car' || ride_type_category == 'Chander Pahar Car' ||
                    ride_type_category == 'Ambulance' || ride_type_category == 'Truck' ||
                    ride_type_category == 'Bus' || ride_type_category == 'Helicopter' ||
                    ride_type_category == 'Hire Driver' || ride_type_category == 'Self Driving Car') {
                    $('#edit_fare_category_section').removeClass('d-none');
                    $('#edit_per_day_fare_section').removeClass('d-none');
                    $('#edit_per_week_fare_section').removeClass('d-none');
                    $('#edit_per_month_fare_section').removeClass('d-none');
                    $('#edit_holiday_fare_section').removeClass('d-none');
                    $('#edit_per_holiday_fare_section').removeClass('d-none');
                } else {
                    $('#edit_fare_category_section').addClass('d-none');
                    $('#edit_per_day_fare_section').addClass('d-none');
                    $('#edit_per_week_fare_section').addClass('d-none');
                    $('#edit_per_month_fare_section').addClass('d-none');
                    $('#edit_holiday_fare_section').addClass('d-none');
                    $('#edit_per_holiday_fare_section').addClass('d-none');
                }

                if (ride_type_category == 'Schedule Car' || ride_type_category == 'Hourly Car' ||
                    ride_type_category == 'Intercity' || ride_type_category == 'Rental Car' ||
                    ride_type_category == 'Chander Pahar Car' || ride_type_category == 'Ambulance' ||
                    ride_type_category == 'Truck' || ride_type_category == 'Bus' || ride_type_category ==
                    'Helicopter' || ride_type_category == 'Hire Driver' || ride_type_category ==
                    'Self Driving Car') {
                    $('#edit_per_hour_fare_section').removeClass('d-none');
                } else {
                    $('#edit_per_hour_fare_section').addClass('d-none')
                }

            })

        });
    </script>
@endsection
@endsection
