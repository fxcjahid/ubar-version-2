<div class="driver-docoment-files">
    <div class="row">
        <div class="col-12 m-0">
            <div class="heading">
                Licence Picture Upload
            </div>
        </div>
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Licence Front Picture</p>
                @if ($user->files()->where('key', 'driver_licence_front_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'driver_licence_front_picture')->first()->path }}"
                        alt="Profile Picture" class="profile rounded-bottom rounded-top" width="50px" height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Licence Back Picture</p>
                @if ($user->files()->where('key', 'driver_licence_back_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'driver_licence_back_picture')->first()->path }}"
                        alt="Profile Picture" class="profile rounded-bottom rounded-top" width="50px" height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 m-0">
            <div class="heading1">
                <h2>Car Picture Upload</h2>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Picture</p>
                @if ($user->files()->where('key', 'car_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_picture')->first()->path }}" alt="Car Picture"
                        class="profile rounded-bottom rounded-top" width="50px" height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Front Side Picture</p>
                @if ($user->files()->where('key', 'car_front_side_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_front_side_picture')->first()->path }}"
                        alt="Car Front Side Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Back Side Picture</p>
                @if ($user->files()->where('key', 'car_back_side_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_back_side_picture')->first()->path }}"
                        alt="Car Back Side Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Inside Front Picture</p>
                @if ($user->files()->where('key', 'car_inside_front_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_inside_front_picture')->first()->path }}"
                        alt="Car Inside Front Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Inside Back Picture</p>
                @if ($user->files()->where('key', 'car_inside_back_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_inside_back_picture')->first()->path }}"
                        alt="Car Inside Back Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Registration Picture</p>
                @if ($user->files()->where('key', 'car_registration_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_registration_picture')->first()->path }}"
                        alt="Car Registration Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Tax Token Licence Picture</p>
                @if ($user->files()->where('key', 'car_tax_token_licence_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_tax_token_licence_picture')->first()->path }}"
                        alt="Car Tax Token Licence Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Fitness Licence Picture</p>
                @if ($user->files()->where('key', 'car_fitness_licence_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_fitness_licence_picture')->first()->path }}"
                        alt="Car Fitness Licence Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Insurance Licence Picture</p>
                @if ($user->files()->where('key', 'car_insurance_licence_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_insurance_licence_picture')->first()->path }}"
                        alt="Car Insurance Licence Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Route Permit Licence Picture</p>
                @if ($user->files()->where('key', 'car_route_permit_licence_pictute')->exists())
                    <img src="{{ $user->files()->where('key', 'car_route_permit_licence_pictute')->first()->path }}"
                        alt="Car Route Permit Licence Picture" class="profile rounded-bottom rounded-top"
                        width="50px" height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Owner NID Picture</p>
                @if ($user->files()->where('key', 'car_owner_nid_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_owner_nid_picture')->first()->path }}"
                        alt="Car Route Permit Licence Picture" class="profile rounded-bottom rounded-top"
                        width="50px" height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Owner Picture</p>
                @if ($user->files()->where('key', 'car_owner_profile_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_owner_profile_picture')->first()->path }}"
                        alt="Car Owner Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Owner Utility Picture</p>
                @if ($user->files()->where('key', 'car_owner_utility_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'car_owner_utility_picture')->first()->path }}"
                        alt="Car Owner Utility Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Sale Deed Paper 01</p>
                @if ($user->files()->where('key', 'car_sale_dead_paper_01')->exists())
                    <img src="{{ $user->files()->where('key', 'car_sale_dead_paper_01')->first()->path }}"
                        alt="Car Sale Deed Paper 01" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Car Sale Deed Paper 02</p>
                @if ($user->files()->where('key', 'car_sale_dead_paper_02')->exists())
                    <img src="{{ $user->files()->where('key', 'car_sale_dead_paper_02')->first()->path }}"
                        alt="Car Sale Deed Paper 02" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

    </div>


    <br />

    <div class="row">
        <div class="col-12">
            <div class="heading">
                Driver Picture Upload
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Driver Profile Picture</p>
                @if ($user->files()->where('key', 'driver_licence_front_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'driver_licence_front_picture')->first()->path }}"
                        alt="Profile Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Driver NID Picture</p>
                @if ($user->files()->where('key', 'driver_nid_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'driver_nid_picture')->first()->path }}"
                        alt="Driver NID Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <p>Driver Utility Picture</p>
                @if ($user->files()->where('key', 'driver_utility_picture')->exists())
                    <img src="{{ $user->files()->where('key', 'driver_utility_picture')->first()->path }}"
                        alt="Driver Utility Picture" class="profile rounded-bottom rounded-top" width="50px"
                        height="50px">
                @else
                    <div class="form-group">No Image</div>
                @endif
            </div>
        </div>


    </div>
</div>
