<!-- Sidebar  -->
<style>
    i,
    span {
        display: inline-block;
        color: #d9d9d9;
    }
</style>
<nav id="sidebar">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
                <a href="index.html"><img class="logo_icon img-responsive"
                        src="{{ asset('assets/images/layout_img/user_img.jpg') }}" alt="#" /></a>
            </div>
        </div>
        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
                <div class="user_img"><img class="img-responsive"
                        src="{{ asset('assets/images/layout_img/user_img.jpg') }}" alt="#" /></div>
                <div class="user_info">
                    <h6>{{ Auth::user()->name }}</h6>
                    <p><span class="online_animation"></span> Online</p>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar_blog_2">
        <h4>General</h4>
        <!-- <ul class="list-unstyled components" style="background-color: #ffc107"> old -->
        <ul class="list-unstyled components" style="background-color: #010F58">
            @can('dashboard')
                <li class="active">
                <li>
                    <a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard white_color"></i>
                        <span>Dashboard</span></a>

                </li>
            @endcan
            @can('vehicle-location')
                <li>
                    <a target='_blank' href="{{ route('admin.vehicle-location') }}"><i
                            class="fa fa-map-marker white_color"></i> <span>Vehicle Location</span></a>
                </li>
            @endcan
            @can('types')

                <li>
                    <a href="#type" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-paper-plane white_color"></i> <span>Ride type</span></a>
                    <ul class="collapse list-unstyled" id="type">
                        @can('type-list')
                            <li>
                                <a href="{{ route('type.index') }}">> <span>Ride Type List</span></a>
                            </li>
                        @endcan
                        @can('type-create')
                            <li>
                                <a href="{{ route('type.create') }}">> <span>Add RIde Type</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('categories')
                <li>
                    <a href="#category" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-paper-plane white_color"></i> <span>Vehicle Category</span></a>
                    <ul class="collapse list-unstyled" id="category">
                        @can('category-list')
                            <li>
                                <a href="{{ route('admin.category') }}">> <span>Vehicle Category List</span></a>
                            </li>
                        @endcan
                        @can('category-create')
                            <li>
                                <a href="{{ route('admin.category.create') }}">> <span>Add Vehicle Category</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('vehicles')
                <li>
                    <a href="#vehicle" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-car blue2_color"></i> <span>Vehicles</span></a>
                    <ul class="collapse list-unstyled" id="vehicle">
                        @can('vehicle-list')
                            <li><a href="{{ route('admin.vehicle') }}">> <span>All Vehicles</span></a></li>
                        @endcan
                        @can('vehicle-create')
                            <li><a href="{{ route('admin.vehicle.create') }}">> <span>Add Vehicles</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan

            @can('vehicles')
                <li>
                    <a href="#payment" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-usd blue2_color"></i> <span>Payments</span></a>
                    <ul class="collapse list-unstyled" id="payment">
                        <!--@can('vehicle-list')
        -->
                            <li><a href="{{ route('admin.manual.payment') }}">> <span>Payment List</span></a></li>
                            <!--
    @endcan-->


                    </ul>
                </li>
            @endcan
            @can('roles')

                <li>
                    <a href="#role" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-paper-plane white_color"></i> <span>Roles</span></a>
                    <ul class="collapse list-unstyled" id="role">
                        @can('role-list')
                            <li>
                                <a href="{{ route('roles.index') }}">> <span>Role List</span></a>
                            </li>
                        @endcan
                        @can('role-create')
                            <li>
                                <a href="{{ route('roles.create') }}">> <span>Add Role</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('cities')
                <li>
                    <a href="#city" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-paper-plane white_color"></i> <span>City </span></a>
                    <ul class="collapse list-unstyled" id="city">
                        @can('city-list')
                            <li>
                                <a href="{{ route('admin.city') }}">> <span>City List</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('booking-list')
                <li>
                    <a href="#booking_history" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-list purple_color2"></i> <span>Booking List</span></a>
                    <ul class="collapse list-unstyled" id="booking_history">
                        <li>
                            @can('ride-history')
                                <a href="{{ route('admin.booking_list') }}">> <span>Ride History</span></a>
                            @endcan
                            @can('payment-history')
                                <a href="#">> <span>Payment History</span></a>
                            @endcan
                        </li>
                    </ul>
                </li>
            @endcan
            @can('withdraws')
                <li>
                    <a href="#withdraw" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-user blue2_color"></i> <span>Payout/Withdraw</span></a>
                    <ul class="collapse list-unstyled" id="withdraw">
                        @can('withdraw-list')
                            <li><a href="{{ route('admin.withdraw') }}">> <span>All Withdraw list</span></a></li>
                        @endcan
                        @can('withdraw-create')
                            <li><a href="{{ route('admin.withdraw.create') }}">> <span>Add Withdraw</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('super-admins')
                <li>
                    <a href="#super-admin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-user purple_color"></i> <span>Super Admin</span></a>
                    <ul class="collapse list-unstyled" id="super-admin">
                        @can('super-admin-list')
                            <li><a href="{{ route('admin.super-admin') }}">> <span>Super Admin List</span></a></li>
                        @endcan
                        @can('super-admin-create')
                            <li><a href="{{ route('admin.super-admin.create') }}">> <span>Add Super Admin</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('managers')
                <li>
                    <a href="#employee" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-user purple_color"></i> <span>Manager</span></a>
                    <ul class="collapse list-unstyled" id="employee">
                        @can('manager-list')
                            <li><a href="{{ route('admin.manager') }}">> <span>Manager List</span></a></li>
                        @endcan
                        @can('manager-create')
                            <li><a href="{{ route('admin.manager.create') }}">> <span>Add Manager</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('city-admins')
                <li>
                    <a href="#cityAdmin" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-user purple_color"></i> <span>City Admin</span></a>
                    <ul class="collapse list-unstyled" id="cityAdmin">
                        @can('city-admin-list')
                            <li><a href="{{ route('admin.cityadmin') }}">> <span>City Admin List</span></a></li>
                        @endcan
                        @can('city-admin-create')
                            <li><a href="{{ route('admin.cityadmin.create') }}">> <span>Add City Admin</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('city-agents')
                <li>
                    <a href="#cityAgent" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-user purple_color"></i> <span>City Agent</span></a>
                    <ul class="collapse list-unstyled" id="cityAgent">
                        @can('city-agent-list')
                            <li><a href="{{ route('admin.cityagent') }}">> <span>City Agent List</span></a></li>
                        @endcan
                        @can('city-agent-create')
                            <li><a href="{{ route('admin.cityagent.create') }}">> <span>Add City Agent</span></a></li>
                        @endcan

                    </ul>
                </li>
            @endcan
            @can('users')
                <li>
                    <a href="#user" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-user blue2_color"></i> <span>User</span></a>
                    <ul class="collapse list-unstyled" id="user">
                        @can('user-list')
                            <li><a href="{{ route('admin.user') }}">> <span>All User</span></a></li>
                        @endcan
                        @can('user-create')
                            <li><a href="{{ route('admin.user.create') }}">> <span>Add User</span></a></li>
                        @endcan
                        @can('new-user-list')
                            <li><a href="{{ route('admin.user.new-user-list') }}">> <span>New User List</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('drivers')
                <li>
                    <a href="#driver" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-user blue2_color"></i> <span>Driver</span></a>
                    <ul class="collapse list-unstyled" id="driver">
                        @can('driver-list')
                            <li><a href="{{ route('admin.driver') }}">> <span>All Driver</span></a></li>
                        @endcan
                        @can('driver-create')
                            <li><a href="{{ route('admin.driver.create') }}">> <span>Add Driver</span></a></li>
                        @endcan
                        @can('new-driver-list')
                            <li><a href="{{ route('admin.driver.new-driver') }}">> <span>New Driver List</span></a></li>
                        @endcan
                    </ul>
                </li>
            @endcan

            @can('admin-referral')
                <li>
                    <a href="{{ route('referal.index') }}">
                        <i class="fa fa-users white_color"></i>
                        <span>Referral</span>
                    </a>
                </li>
            @endcan

            @can('settings')
                <li class="active">
                    <a href="#setting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-cog white_color"></i> <span>Settings</span></a>
                    <ul class="collapse list-unstyled" id="setting">
                        @can('manual-booking-list')
                            <li>
                                <a href="{{ route('admin.general.settings') }}">> <span>General Setting</span></a>
                            </li>
                        @endcan
                        @can('company-commissions')
                            <li>
                                <a href="{{ route('admin.company-commission.index') }}">> <span>Company Commission</span></a>
                            </li>
                        @endcan
                        @can('agent-commissions')
                            <li>
                                <a href="{{ route('admin.agent-commission.index') }}">> <span>Agent Commission</span></a>
                            </li>
                            <li>
                                <a href="{{ route('admin.offer.index') }}">> <span>Offer Setting</span></a>
                            </li>
                        @endcan
                        @can('coupons')
                            <li>
                                <a href="{{ route('admin.coupon.index') }}">> <span>Coupon Setting</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('fare-settings')
                <li class="active">
                    <a href="#fares" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-cog white_color"></i> <span>Fares Setting</span></a>
                    <ul class="collapse list-unstyled" id="fares">
                        @can('fare-setting-list')
                            <li>
                                <a href="{{ route('admin.fare.index') }}">> <span>Fares Setting</span></a>
                            </li>
                        @endcan

                        @can('fare-setting-list')
                            <li>
                                <a href="{{ route('fare-category.index') }}">> <span>Fares Categoey</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('manual-bookings')
                <li class="active">
                    <a href="#manual_booking" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-cog white_color"></i> <span>Manual Booking</span></a>
                    <ul class="collapse list-unstyled" id="manual_booking">
                        @can('manual-booking-list')
                            <li>
                                <a href="{{ route('admin.manual-booking') }}">> <span>Manual Booking List</span></a>
                            </li>
                        @endcan
                        @can('manual-booking-create')
                            <li>
                                <a href="{{ route('admin.manual.create') }}">> <span>Add Manual Booking</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('assign-drivers')
                <li><a href="{{ route('admin.assign.index') }}"><i class="fa fa-cog purple_color2"></i> <span>Assign
                            Driver To Vehicles</span></a></li>
            @endcan

            @can('assign-drivers')
                <li><a href="{{ route('admin.assign.index') }}"><i class="fa fa-cog purple_color2"></i> <span>Assign
                            Driver To Vehicles</span></a></li>
            @endcan

            @can('admin-send-mail')
                <li>
                    <a href="{{ route('admin.email.send') }}">
                        <i class="fa fa-cog purple_color2"></i>
                        <span>Send Email</span>
                    </a>
                </li>
            @endcan

            @can('admin-feedback')
                <li class="active">
                    <a href="#feedback" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                            class="fa fa-cog white_color"></i> <span>Feedback</span></a>
                    <ul class="collapse list-unstyled" id="feedback">
                        <li>
                            <a href="{{ route('admin.user.feedback') }}"> <span>User Feedback</span></a>
                        </li>
                        <li>
                            <a href="{{ route('admin.driver.feedback') }}"> <span>Driver Feedback</span></a>
                        </li>
                    </ul>
                </li>
            @endcan

        </ul>
    </div>
</nav>
<!-- end sidebar -->
