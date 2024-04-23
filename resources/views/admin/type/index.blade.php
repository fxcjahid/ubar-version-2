@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
<div class="container-fluid">
    <div class="row column_title">
       <div class="col-md-12">
          <div class="page_title ">
                <h2>Type List</h2>
                @can('type-create')
                <div class="float-right ">
                    <a href="{{ route('type.create')}}" class="btn btn-primary btn-sm ">Add Type</a>
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
                   <h2>Type List</h2>
                </div>

             </div>
             <div class="table_section padding_infor_info">
                <div class="table-responsive-sm">
                   <table id="type-data"  class="table display nowrap">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>Name</th>
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

            $('#type-data').dataTable({
                "processing": true,
                pageLength: 10,
                "serverSide": true,
                "bDestroy": true,
                'checkboxes': {
                    'selectRow': true
                },
                "ajax": {
                    url: "{{route('admin.type.list_ajax')}}",
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
                        "name": "name",
                        'searchable': true,
                        'orderable': true
                    },

                    {
                        "targets": 2,
                        "name": "status",
                        'searchable': false,
                        'orderable': false
                    },
                    {
                        "targets": 3,
                        "name": "created_by",
                        'searchable': false,
                        'orderable': false
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

        //Remove type process
        $("body").on("click", ".remove-type", function(e) {
            e.preventDefault();
            let typeId = $(this).data('id');
            let fd = new FormData();
            fd.append('typeId', typeId);
            fd.append('_token', '{{ csrf_token() }}');
            $.confirm({
                title: 'Confirm!',
                content: 'Sure you want to remove type ?',
                buttons: {
                    yes: function() {
                        $.ajax({
                                url: "{{ route('admin.type.destroy')}}",
                                type: 'POST',
                                data: fd,
                                dataType: "JSON",
                                contentType: false,
                                processData: false,
                            })
                            .done(function(result) {
                                if (result.status) {
                                    toast.success(result.message);
                                    $('#type-data').DataTable().ajax.reload(null, false);
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

