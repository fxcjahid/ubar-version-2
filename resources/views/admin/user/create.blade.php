@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">

                    <span><a href="{{ route('admin.user') }}"><i class="fa fa-arrow-left black"></i>Back</a>&nbsp;&nbsp;&nbsp;
                        <h2>Add User</h2>
                    </span>
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
                            <h2>Create User</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        <form id="add-user" method="POST">
                            <div class="row">
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            placeholder="Enter First Name" required>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            placeholder="Enter Last Name" required>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Phone </label>
                                            <input type="number" class="form-control" name="phone"
                                                placeholder="Phone Number" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Emergency Contact Number</label>
                                            <input type="number" class="form-control" name="phone"
                                                placeholder="Emergency Contact Number" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Enter E-mail" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Gender</label>
                                            <select class="form-control" name="password" required>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="others">others</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Enter Password" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-xl-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <textarea type="text" class="form-control" name="address" cols="4" rows="2"></textarea>
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Profile Picture</label>
                                        <input type="file" class="form-control" name="profile_image">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Utility Bill Picture</label>
                                        <input type="file" class="form-control" name="profile_image">
                                    </div>
                                </div>

                                <div class="col-6 col-sm-12 col-md-6 col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">NID Picture</label>
                                        <input type="file" class="form-control" name="profile_image">
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
            $('#add-user').on('submit', function(e) {
                e.preventDefault();
                let fd = new FormData($("#add-user")[0])
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    url: "{{ route('admin.user.store') }}",
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
                                    "{{ url('admin/user') }}";
                            }, 1000);
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
