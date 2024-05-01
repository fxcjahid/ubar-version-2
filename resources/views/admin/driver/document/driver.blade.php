<div class="-mt-0">
    <div class="heading">
        Driver Personal Information
    </div>
    <div class="row">
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>First Name</p>
            <div class="form-control">{{ $user->first_name }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Last Name</p>
            <div class="form-control">{{ $user->last_name }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Phone Number</p>
            <div class="form-control">{{ $user->phone }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Email</p>
            <div class="form-control">{{ $user->email }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Gender</p>
            <div class="form-control">
                {{ $user->userInfo->gender == '' ? 'Choose One' : ucfirst($user->userInfo->gender) }}
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6 password">
            <p>Password</p>
            <div class="form-control">*****</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Address</p>
            <div class="form-control">{{ $user->driverInfo->address }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Driving Experience in (car)</p>
            <div class="form-control">{{ $user->driverInfo->experience_in_car }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Driving Experience in (year)</p>
            <div class="form-control">{{ $user->driverInfo->experience_in_year }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Driver Licence Number</p>
            <div class="form-control">{{ $user->driverInfo->licence_number }}</div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Driver NID Number</p>
            <div class="form-control">{{ $user->driverInfo->nid_number }}</div>
        </div>
    </div>
</div>
