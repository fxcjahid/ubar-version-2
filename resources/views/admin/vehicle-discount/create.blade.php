@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid vehicles-discount-created">
        <div class="row">
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Create Vehicle Discount</h2>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="padding_infor_info">
                        <form id="add-vehicle" action="{{ route('admin.vehicles.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">Discount Name</label>
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="vehicle_type">Select Vehicle Type</label>
                                                <select class="form-control type" name="vehicle_type" required>
                                                    <option value="">Select Type</option>
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}">{{ $type->t_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="vehicle_number">Vehicle Number</label>
                                                <input type="number" class="form-control" name="vehicle_number">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="discount_code">Discount Code</label>
                                                <input type="text" class="form-control" name="discount_code" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="discount_type">Discount Type</label>
                                                <select class="form-control category" name="discount_type" required>
                                                    <option value="fixed">Fixed</option>
                                                    <option value="percent">Percent</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="discount_amount">Discount Amount</label>
                                                <input type="number" class="form-control" name="discount_amount" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="start_at">Start Date</label>
                                                <input type="date" class="form-control" name="start_at" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="expired_at">Expired Date</label>
                                                <input type="date" class="form-control" name="expired_at" required>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="checkbox" value="1" class="form-control" name="status"
                                                    checked>
                                                <label for="status">Status</label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="float-right">
                                <button type="submit" name="submit" class="btn btn-success">Save</button>
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
            $('#add-vehicle').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData($(this)[0]);

                $.ajax({
                    url: $(this).attr('action'),
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#load').show();
                    },
                    success: function(response) {
                        if (response.status) {
                            toast.success('Discount has created');
                            setTimeout(function() {
                                window.location.href =
                                    "{{ route('admin.vehicles.list') }}";
                            }, 500);
                        } else {
                            toast.error(response.message);
                        }
                    },
                    error: function(jqXHR, exception) {
                        if (jqXHR.status === 422) {
                            let errors = jqXHR.responseJSON.errors;
                            let errorMessage = "Validation error:<br>";
                            $.each(errors, function(key, value) {
                                errorMessage += value + "<br>";
                            });
                            toast.error(errorMessage);
                        } else {
                            toast.error('An error occurred while processing your request.');
                        }
                    },
                    complete: function() {
                        $('#load').hide();
                    }
                });
            });

        });
    </script>
@endsection
@endsection
