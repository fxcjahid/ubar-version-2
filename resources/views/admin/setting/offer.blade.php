@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Offer</h2>
                    @can('offer-create')
                    <div class="float-right ">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#offerModal">
                            Add Offer
                        </button>
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
                            <h2>Offer List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="offer-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Offer Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Percentage</th>
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
                <div class="modal fade" id="offerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Offer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="add-offer" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Offer Code</label>
                                                <input type="text" class="form-control" name="offer_code"
                                                    placeholder="Enter Code" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Start Date</label>
                                                <input type="date" class="form-control" name="start_date"
                                                 required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">End Date</label>
                                                <input type="date" class="form-control" name="end_date"
                                                     required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Discount(%)</label>
                                                <input type="text" class="form-control" name="discount"
                                                    placeholder="Enter Code" required>
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
                <div class="modal fade" id="editOfferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Offer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="edit-offer" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Offer Code</label>
                                                <input type="text" class="form-control" name="offer_code"
                                                    placeholder="Enter Code" required id="edit_offer_code">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Start Date</label>
                                                <input type="date" class="form-control" name="start_date"
                                                 required id="edit_start_date">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">End Date</label>
                                                <input type="date" class="form-control" name="end_date"
                                                     required id="edit_end_date">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Discount(%)</label>
                                                <input type="text" class="form-control" name="discount"
                                                    placeholder="Enter Code" required id="edit_discount">
                                            </div>
                                        </div>
                                        <input type="hidden" name="offerId" id="offerId">

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

                $('#offer-data').dataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "bDestroy": true,
                    'checkboxes': {
                        'selectRow': true
                    },
                    "ajax": {
                        url: "{{ route('admin.offer.offer-list') }}",
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
                            "name": "offer_code",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 2,
                            "name": "start_date",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 3,
                            "name": "end_date",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 4,
                            "name": "discount",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 5,
                            "name": "status",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 6,
                            "name": "action",
                            'searchable': false,
                            'orderable': false
                        },
                    ]
                });
            }
            $.fn.tableload();

            // Add City process
            $('#add-offer').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-offer")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.offer.store') }}",
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
                            $('#add-offer')[0].reset();
                            $("#offerModal").modal("toggle");
                            $('#offer-data').DataTable().ajax.reload(null, false);
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
            $("body").on("click", ".remove-offer", function(e) {
                e.preventDefault();
                let offerId = $(this).data('id');
                let fd = new FormData();
                fd.append('offerId', offerId);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to remove offer ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.offer.offer-remove') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#offer-data').DataTable().ajax.reload(null,
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

            // City Status Change
            $("body").on("click", ".updateOffer", function(e) {
                e.preventDefault();
                let offerId = $(this).data('id');
                let status = $(this).data('status');
                let fd = new FormData();
                fd.append('offerId', offerId);
                fd.append('status', status);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to change status ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.offer.offer-status') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#offer-data').DataTable().ajax.reload(null,
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
            $("body").on("click" , ".editOffer" , function() {
                var offer_code    = $(this).data('offer_code');
                var start_date  = $(this).data('start_date');
                var end_date  = $(this).data('end_date');
                var percentage  = $(this).data('percentage');
                var offerId  = $(this).data('id');

                $("#edit_offer_code").val(offer_code);
                $("#edit_start_date").val(start_date);
                $("#edit_end_date").val(end_date);
                $("#edit_discount").val(percentage);
                $("#offerId").val(offerId);
                $("#editOfferModal").modal("toggle");
            })

            // Update City
            $('#edit-offer').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#edit-offer")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.offer.offer-update') }}",
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
                            $('#edit-offer')[0].reset();
                            $("#editOfferModal").modal("toggle");
                            $('#offer-data').DataTable().ajax.reload(null, false);
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


        });
    </script>
@endsection
@endsection
