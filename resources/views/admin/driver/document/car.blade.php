<div class="driver-docoment">
    <div class="heading">
        Car Information
    </div>
    <div class="row">

        <!-- Car Owner Name -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Owner Name</p>
            <div class="form-control">{{ $user->car->owner_name ?? 'N/A' }}</div>
        </div>

        <!-- Car Owner Bank Acc No. -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Owner Bank Acc No.</p>
            <div class="form-control">{{ $user->car->owner_bank_acc ?? 'N/A' }}</div>
        </div>

        <!-- Car Owner Mobile Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Owner Mobile Number</p>
            <div class="form-control">{{ $user->car->owner_mobile_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Owner NID number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Owner NID number</p>
            <div class="form-control">{{ $user->car->owner_nid_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Model Name -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Model Name</p>
            <div class="form-control">{{ $user->car->model_name ?? 'N/A' }}</div>
        </div>

        <!-- Car Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Number</p>
            <div class="form-control">{{ $user->car->car_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Registration Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Registration Number</p>
            <div class="form-control">{{ $user->car->registration_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Color Name -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Color Name</p>
            <div class="form-control">{{ $user->car->color_name ?? 'N/A' }}</div>
        </div>

        <!-- Car Engine Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Engine Number</p>
            <div class="form-control">{{ $user->car->engine_number ?? 'N/A' }}</div>
        </div>

        <!-- Car C.C Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car C.C Number</p>
            <div class="form-control">{{ $user->car->cc_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Seats Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Seats Number</p>
            <div class="form-control">{{ $user->car->seats_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Chassize Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Chassize Number</p>
            <div class="form-control">{{ $user->car->chassize_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Bluebook Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Bluebook Number</p>
            <div class="form-control">{{ $user->car->bluebook_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Route Permit Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Route Permit Number</p>
            <div class="form-control">{{ $user->car->route_permit_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Fleetness Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Fleetness Number</p>
            <div class="form-control">{{ $user->car->fleetness_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Fitness Ensuring Date -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Fitness Ensuring Date</p>
            <div class="form-control">{{ $user->car->fitness_ensuring_at ?? 'N/A' }}</div>
        </div>

        <!-- Car Fitness Expired Date -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Fitness Expired Date</p>
            <div class="form-control">{{ $user->car->fitness_expired_at ?? 'N/A' }}</div>
        </div>

        <!-- Car Insurance Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Insurance Number</p>
            <div class="form-control">{{ $user->car->insurance_number ?? 'N/A' }}</div>
        </div>

        <!-- Car Tax Token Number -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car Tax Token Number</p>
            <div class="form-control">{{ $user->car->tax_token_number ?? 'N/A' }}</div>
        </div>

        <!-- Ride Service -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Ride Service</p>
            <div class="form-control">{{ $user->car->ride_service ?? 'N/A' }}</div>
        </div>

        <!-- Ride Package -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Ride Package</p>
            <div class="form-control">{{ $user->car->ride_package ?? 'N/A' }}</div>
        </div>

        <!-- Car GPS Tracking -->
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <p>Car GPS Tracking</p>
            <div class="form-control">{{ $user->car->gps_tracking ?? 'N/A' }}</div>
        </div>

    </div>
</div>
