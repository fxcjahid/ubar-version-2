@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
<div class="container-fluid">
    <div class="row column_title">
       <div class="col-md-12">
          <div class="page_title ">
                <h2>Category List</h2>
                @can('manual-booking-create')
             <div class="float-right ">
                <a href="{{ route('admin.manual.create')}}" class="btn btn-primary btn-sm ">Add Manual Booking</a>
            </div>
            @endcan
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
                   <h2>Manual Booking List</h2>
                </div>

             </div>
             <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                   <table id="booking-list"  class="table display nowrap">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>Booking ID</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Booking Start Date</th>
                            <th>Booking End Date</th>
                            <th>Advance Amount</th>
                            <th>Pending Amount</th>
                            <th>Total  Amount</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Action</th>
                         </tr>
                      </thead>
                      <tbody>
                      </tbody>
                   </table>
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

            $('#booking-list').dataTable({
                "processing": true,
                pageLength: 10,
                "serverSide": true,
                "bDestroy": true,
                'checkboxes': {
                    'selectRow': true
                },
                "ajax": {
                    url: "{{route('admin.manual.booking-list')}}",
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
                "columns": [
                    {
                        "targets": 0,
                        "name": "id",
                        'searchable': false,
                        'orderable': true
                    },
                    {
                        "targets": 1,
                        "name": "booking_id",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 2,
                        "name": "customer_name",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 3,
                        "name": "phone",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 4,
                        "name": "email",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 5,
                        "name": "booking_start_date",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 6,
                        "name": "booking_end_date",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 7,
                        "name": "advance_amnt",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 8,
                        "name": "pending_amnt",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 9,
                        "name": "total_amnt",
                        'searchable': true,
                        'orderable': true
                    },
                    {
                        "targets": 10,
                        "name": "status",
                        'searchable': false,
                        'orderable': false
                    },
                    {
                        "targets": 11,
                        "name": "created_by_id",
                        'searchable': false,
                        'orderable': false
                    },
                    {
                        "targets": 12,
                        "name": "action",
                        'searchable': false,
                        'orderable': false
                    },
                ]
            });
        }
        $.fn.tableload();

        //Remove Category process
        $("body").on("click", ".remove-booking", function(e) {
            e.preventDefault();
            let bookingId = $(this).data('id');
            let fd = new FormData();
            fd.append('bookingId', bookingId);
            fd.append('_token', '{{ csrf_token() }}');
            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to remove this booking ?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('admin.manual.remove')}}",
                                type: 'POST',
                                data: fd,
                                dataType: "JSON",
                                contentType: false,
                                processData: false,
                            })
                            .done(function(result) {
                                if (result.status) {
                                    toast.success(result.message);
                                    $('#booking-list').DataTable().ajax.reload(null, false);
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

    });
</script>
@endsection
@endsection

