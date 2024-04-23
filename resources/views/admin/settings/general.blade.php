@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('type.index') }}"><i
                                class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;<h2>Settings</h2></span>
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
                            <h2>Settings Update</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form action="{{ route ('admin.settings') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company Name</label>
                                        <input type="text" class="form-control" value="{{get_option('company_name')}}" name="company_name"
                                            placeholder="Enter Company Name" required>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company address</label>
                                        <input type="text" class="form-control" value="{{get_option('address')}}" name="address"
                                            placeholder="Enter Company address" required>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company email</label>
                                        <input type="email" class="form-control" value="{{get_option('email')}}" name="email"
                                            placeholder="Enter Company email" required>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company phone</label>
                                        <input type="text" class="form-control" value="{{get_option('phone')}}" name="phone"
                                            placeholder="Enter Company phone" required>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company Commission</label>
                                        <input type="number" class="form-control" value="{{get_option('company_commission')}}" name="company_commission"
                                            placeholder="Enter company Commission" required>
                                    </div>
                                </div>
                                
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">City Agent Commission</label>
                                        <input type="number" class="form-control" value="{{get_option('city_agent_commission')}}" name="city_agent_commission"
                                            placeholder="Enter City Agent Commission" required>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Driver Fund Commission</label>
                                        <input type="number" class="form-control" value="{{get_option('driver_fund_commission')}}" name="driver_fund_commission"
                                            placeholder="Enter Driver Fund Commission" required>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company Logo</label>
                                        <input type="file" name="logo" id="logo" class="form-control"> 
                                        @if(get_option('logo'))
                                            <input type="hidden" name="oldLogo" value="{{get_option('logo')}}">
                                            <img src="{{url(get_option('logo'))}}" id="output" style="width: 50px; height:50px" class="rounded" />
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Company Favicon</label>
                                        <input type="file" name="favicon" id="favicon" class="form-control"> 
                                        @if(get_option('favicon'))
                                            <input type="hidden" name="oldfavicon" value="{{get_option('favicon')}}">
                                            <img src="{{url(get_option('favicon'))}}" id="output" style="width: 50px; height:50px" class="rounded" />
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="float-right">
                                <button type="submit" name="submit" class="btn btn-success">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('extra_js')
    <script>
        $(function() {
            $('#add-type').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-type")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('type.store') }}",
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
                            setTimeout(function() {
                                window.location.href =
                                    "{{ url('admin/type') }}";
                            }, 500);
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


