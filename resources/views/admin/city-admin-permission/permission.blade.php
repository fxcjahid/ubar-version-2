@extends('admin.layouts.layout')

@section('extra_css')
    <style>
        /* Hiding the checkbox, but allowing it to be focused */
        .badgebox {
            opacity: 0;
        }

        .badgebox+.badge {
            /* Move the check mark away when unchecked */
            text-indent: -999999px;
            /* Makes the badge's width stay the same checked and unchecked */
            width: 27px;
        }

        .badgebox:focus+.badge {
            /* Set something to make the badge looks focused */
            /* This really depends on the application, in my case it was: */

            /* Adding a light border */
            box-shadow: inset 0px 0px 10px;
            /* Taking the difference out of the padding */
        }

        .badgebox:checked+.badge {
            /* Move the check mark back when checked */
            text-indent: 0;
            font-size: 18px;
        }
    </style>
@endsection
@section('section')
    @php

        /**
         * @This Method use to enter module and submodules which are newly created in erp for assigns the privileges to the users
         */

        /** @module list array */

        $modules = [
            '1' => 'Dashboard',
            '2' => 'Category',
            '3' => 'City',
            '4' => 'Manager',
            '5' => 'User',
            '6' => 'Driver',
            '7' => 'Vehicles',
            '8' => 'Permission Setting',
            '9' => 'Setting'
            '10'=> 'Booking List',
            '11'=> 'Payout / Withdraw',
            '12'=> 'Super Admin',
            '13'=> 'City Admin',
            '14'=> 'Fares',
            '15' => 'Manual Booking',
            '16'=> 'Ride History',
            '17' => 'Assign Driver To Vehicle',
        ];

        /** @submodule list array */

        $submodule = [
            'Dashboard' => [
                '1' => 'Dashboard',
            ],
            'Category' => [
                '1' => 'Category List',
                '2' => 'Add Category',
            ],
            'City' => [
                '1' => 'City',
            ],
            'Manager' => [
                '1' => 'Manager List',
                '2' => 'Add Manager',
            ],
            'User' => [
                '1' => 'All User',
                '2' => 'Add User',
            ],
            'Driver' => [
                '1' => 'All Driver',
                '2' => 'Add Driver',
            ],
            'Vehicles' => [
                '1' => 'All Vehicles',
                '2' => 'Add Vehicles',
            ],
            'Permission Setting' => [
                '1' => 'Permission Setting',
            ],
            'Setting' => [
                '1' => 'Setting',
            ],
            'Booking List' => [
                '1' => 'Booking List',
            ],
            'Payout / Withdraw' => [
                '1' => 'All Withdraw List',
                '2' => 'Add Withdraw',
            ],
            'Super Admin' => [
                '1' => 'Super Admin List',
                '2' => 'Add Super Admin',
            ],
            'City Admin' => [
                '1' => 'City Admin List',
                '2' => 'Add City Admin',
            ],
            'Fares' => [
                '1' => 'Fares',
            ],
            'Manual Booking' => [
                '1' => 'Manual Booking List',
                '2' => 'Add Manual Booking',
            ],
            'Ride History' => [
                '1' => 'Ride History'
            ],
            'Assign Driver To Vehicle' => [
                '1' => 'Assign Driver To Vehicle'
            ]

        ];

    @endphp
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Permission</h2>

                </div>
            </div>
        </div>
        <div class="row">
            <!-- table section -->
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Permission List</h2>
                        </div>

                    </div>
                    <div class="table_section padding_infor_info">
                        <div class="table-responsive-sm">
                            <form action="#" id="setPrivilages">
                                <input type="hidden" name="staff_id" value="{{ $id }}">
                                <table class="table table-responsive nowrap" id="privilege-list">
                                    <thead>
                                        <tr class="text-center">
                                            <th>Check</th>
                                            <th>Module</th>
                                            <th>Privilage</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($modules as $key => $items)
                                            <tr>
                                                @php
                                                    if (App\Helpers\MyHelper::getUserPrivilages($id, $key) === $key) {
                                                        $modulecheck = 'checked';
                                                        $removeModule = '<a href="" class="text-danger">Remove</a>';
                                                    } else {
                                                        $modulecheck = '';
                                                        $removeModule = '';
                                                    }
                                                @endphp
                                                <td><input type="checkbox" class="form-control"
                                                        style="height: 18px; width: 18px" {{ $modulecheck }}
                                                        value="{{ $key }}" name="moduleNo[]">

                                                </td>
                                                <td><b>{{ $items }}</b></td>
                                                <td style="width: 70%">
                                                    <p>
                                                        <a class="btn-sm btn-primary" data-toggle="collapse"
                                                            href="#multiCollapseExample1{{ $key }}" role="button"
                                                            aria-expanded="false" aria-controls="multiCollapseExample1"><i
                                                                class="fa fa-plus"></i> </a>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="collapse multi-collapse"
                                                                id="multiCollapseExample1{{ $key }}">
                                                                <div class="card card-body">
                                                                    @foreach ($submodule as $key1 => $items1)
                                                                        @if ($key1 === $items)
                                                                            <table class="table table-responsive">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>#</th>
                                                                                        <th>Sub modules</th>
                                                                                        <th>Access</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach ($items1 as $key3 => $items2)
                                                                                        <tr>
                                                                                            @php
                                                                                                $privilage = App\Helpers\MyHelper::getUserPrivilages($id, $key, $key3);

                                                                                                if ($privilage && $privilage['submodule'] === $key3) {
                                                                                                    $checkbox = 'checked';
                                                                                                } else {
                                                                                                    $checkbox = '';
                                                                                                }
                                                                                                if ($privilage && $privilage['result'][0]['access'] === 'Read') {
                                                                                                    $read = 'selected';
                                                                                                    $write = '';
                                                                                                    $hidden = 'd-none';
                                                                                                    $add = '';
                                                                                                    $edit = '';
                                                                                                    $delete = '';
                                                                                                } elseif ($privilage && $privilage['result'][0]['access'] === 'Write') {
                                                                                                    $read = '';
                                                                                                    $write = 'selected';
                                                                                                    $hidden = '';
                                                                                                    if ($privilage['result'][0]['add'] === 'on') {
                                                                                                        $add = 'checked';
                                                                                                    } else {
                                                                                                        $add = '';
                                                                                                    }
                                                                                                    if ($privilage['result'][0]['edit'] === 'on') {
                                                                                                        $edit = 'checked';
                                                                                                    } else {
                                                                                                        $edit = '';
                                                                                                    }
                                                                                                    if ($privilage['result'][0]['delete'] === 'on') {
                                                                                                        $delete = 'checked';
                                                                                                    } else {
                                                                                                        $delete = '';
                                                                                                    }
                                                                                                } else {
                                                                                                    $read = '';
                                                                                                    $write = '';
                                                                                                    $hidden = 'd-none';
                                                                                                    $add = '';
                                                                                                    $edit = '';
                                                                                                    $delete = '';
                                                                                                }

                                                                                            @endphp
                                                                                            <td><input type="checkbox"
                                                                                                    class="form-control submodules"
                                                                                                    style="width: 20px; height: 20px"
                                                                                                    value="{{ $key3 }}"
                                                                                                    {{ $checkbox }}
                                                                                                    name="submodule{{ $key }}[]">
                                                                                            </td>
                                                                                            <td>{{ $items2 }}</td>
                                                                                            <td> <select
                                                                                                    class="form-control"
                                                                                                    name="access{{ $key . $key3 }}[]"
                                                                                                    onchange="$.fn.showaccess(this.value , 'writeAcc{{ $key . $key3 }}')">
                                                                                                    <option value="">
                                                                                                        Please Select
                                                                                                    </option>
                                                                                                    <option value="Read"
                                                                                                        {{ $read }}>
                                                                                                        Read</option>
                                                                                                    <option value="Write"
                                                                                                        {{ $write }}>
                                                                                                        Write</option>
                                                                                                </select>
                                                                                                <br>

                                                                                            </td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal-footer center">
                                    <span class="error"></span>
                                    <button type="submit" class="btn btn-success add_privilege add-button" disabled
                                        id="saveData"> <i class="fa fa-spinner fa-spin " id="spin-privilege-add"></i>
                                        Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('extra_js')
    <script>
        $(function(e) {

            $.fn.showaccess = function(e, f) {
                if (e === 'Write') {
                    $('#' + f).removeClass('d-none').show();
                    $('#saveData').removeAttr('disabled');
                } else if (e === 'Read') {
                    $('#' + f).addClass('d-none').hide();
                    $('#saveData').removeAttr('disabled');
                } else if (e === '') {
                    $('#' + f).addClass('d-none').hide();
                }
            }

            $('.badgebox , .submodules').on('click', function(e) {
                $('#saveData').removeAttr('disabled');
            })


            $('#spin-privilege-add').hide();

            // method use for save category
            $('#setPrivilages').on('submit', function(e) {
                e.preventDefault()

                let fd = new FormData(this)
                fd.append('_token', "{{ csrf_token() }}");
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.permission.city-admin') }}",
                    data: fd,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.add-button').prop('disabled', true);
                        $('.cancel-button').prop('disabled', true);
                        $('#spin-privilege-add').show();
                    },
                    success: function(result) {
                        if (result.status) {
                            toast.success(result.msg);
                            setTimeout(function() {
                                window.location.href =
                                    "{{ url('admin/city-admin-permission') }}";
                            }, 500);
                        } else {
                            toast.error(result.msg);
                        }
                    },
                    complete: function() {
                        $("#spin-privilege-add").hide();
                        $('.add-button').prop('disabled', false);
                        $('.cancel-button').prop('disabled', false);
                    },
                    error: function(jqXHR, exception) {
                        $("#spin-privilege-add").hide();
                        $('.add-button').prop('disabled', false);
                        $('.cancel-button').prop('disabled', false);
                        console.log(jqXHR.responseText);
                    }
                });
            })


        })
    </script>
@endsection
