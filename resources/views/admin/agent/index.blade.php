@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Agent List</h2>
                    <div class="float-right ">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#commissionModal">
                            Add Agent Commission
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
                            <h2>Agent Commission List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <table id="commission-data" class="table display nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Commission Type</th>
                                        <th>Commission</th>
                                        <th>City Name</th>
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
                <div class="modal fade" id="commissionModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Agent Commission</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="add-company-commission" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Commission Type</label>
                                                <select class="form-control" name="commission_type" required>
                                                    <option value="">Select Commission Type</option>
                                                    <option value="percentage">Percentage</option>
                                                    <option value="amount">amount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Commission</label>
                                                <input type="
                                                number"
                                                    step="any" min="0" class="form-control" name="commission"
                                                    placeholder="Enter Commission" required>
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
                <div class="modal fade" id="editCommissionModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Agent</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="edit-commission" method="POST">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Commission Type</label>
                                                <select class="form-control" name="commission_type" required
                                                    id="commission_type">
                                                    <option value="">Select Commission Type</option>
                                                    <option value="percentage">Percentage</option>
                                                    <option value="amount">amount</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Commission</label>
                                                <input type="
                                                number"
                                                    step="any" min="0" class="form-control" name="commission"
                                                    placeholder="Enter Commission" required id="commission">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="commission_id" id="commission_id">
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

                $('#commission-data').dataTable({
                    "processing": true,
                    pageLength: 10,
                    "serverSide": true,
                    "bDestroy": true,
                    'checkboxes': {
                        'selectRow': true
                    },
                    "ajax": {
                        url: "{{ route('admin.agent-commission.list') }}",
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
                            "name": "commission_type",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 2,
                            "name": "commission",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 3,
                            "name": "city_name",
                            'searchable': true,
                            'orderable': true
                        },
                        {
                            "targets": 4,
                            "name": "action",
                            'searchable': false,
                            'orderable': false
                        },
                    ]
                });
            }
            $.fn.tableload();

            // Add Fare process
            $('#add-company-commission').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-company-commission")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.agent-commission.store') }}",
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
                            $('#add-company-commission')[0].reset();
                            $("#commissionModal").modal("toggle");
                            $('#commission-data').DataTable().ajax.reload(null, false);
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


            //Remove Commission process
            $("body").on("click", ".remove-commission", function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let fd = new FormData();
                fd.append('id', id);
                fd.append('_token', '{{ csrf_token() }}');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Sure you want to remove commission ?',
                    buttons: {
                        yes: function() {
                            $.ajax({
                                    url: "{{ route('admin.agent-commission.remove') }}",
                                    type: 'POST',
                                    data: fd,
                                    dataType: "JSON",
                                    contentType: false,
                                    processData: false,
                                })
                                .done(function(result) {
                                    if (result.status) {
                                        toast.success(result.message);
                                        $('#commission-data').DataTable().ajax.reload(null,
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
            $("body").on("click", ".editCommission", function() {
                var id = $(this).data('id');
                var commission_type = $(this).data('commission_type');
                var commission = $(this).data('commission');
                $("#commission_id").val(id);
                $("#commission_type").val(commission_type);
                $("#commission").val(commission);
                $("#editCommissionModal").modal("toggle");
            })

            // Update City
            $('#edit-commission').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#edit-commission")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.agent-commission.update') }}",
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
                            $('#edit-commission')[0].reset();
                            $("#editCommissionModal").modal("toggle");
                            $('#commission-data').DataTable().ajax.reload(null, false);
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
