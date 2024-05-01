<br />
<br />
<div class="driver-docoment">
    <div class="heading">
        Car Information
    </div>
    <div class="row">

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="owner_name">Car Owner Name</label>
                <input type="text" class="form-control" name="owner_name">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="owner_bank_acc">Car Owner Bank Acc No.</label>
                <input type="text" class="form-control" name="owner_bank_acc">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="owner_mobile_number">Car Owner Mobile Number</label>
                <input type="text" class="form-control" name="owner_mobile_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="owner_nid_number">Car Owner NID number</label>
                <input type="text" class="form-control" name="owner_nid_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="model_name">Car Model Name</label>
                <input type="text" class="form-control" name="model_name">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_number">Car Number</label>
                <input type="text" class="form-control" name="car_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="registration_number">Car Registration Number</label>
                <input type="text" class="form-control" name="registration_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="color_name">Car Color Name</label>
                <input type="text" class="form-control" name="color_name">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="engine_number">Car Engine Number</label>
                <input type="text" class="form-control" name="engine_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="cc_number">Car C.C Number</label>
                <input type="text" class="form-control" name="cc_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="seats_number">Car Seats Number</label>
                <input type="text" class="form-control" name="seats_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="chassize_number">Car Chassize Number</label>
                <input type="text" class="form-control" name="chassize_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="bluebook_number">Car Bluebook Number</label>
                <input type="text" class="form-control" name="bluebook_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="route_permit_number">Car Route Permit Number</label>
                <input type="text" class="form-control" name="route_permit_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="fleetness_number">Car Fleetness Number</label>
                <input type="text" class="form-control" name="fleetness_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="fitness_ensuring_at">Car Fitness Ensuring Date</label>
                <input type="text" class="form-control" name="fitness_ensuring_at">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="fitness_expired_at">Car Fitness Expired Date</label>
                <input type="text" class="form-control" name="fitness_expired_at">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="insurance_number">Car Insurance Number</label>
                <input type="text" class="form-control" name="insurance_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="tax_token_number">Car Tax Token Number</label>
                <input type="text" class="form-control" name="tax_token_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="ride_service">Ride Service</label>
                    <select class="form-control" name="ride_service">
                        <option value="" selected>Choose One</option>
                        {{-- @foreach ($services as $items)
                            <option value="{{ $items->id }}" {{ old('services') == $items->id ? 'selected' : '' }}>
                                {{ $items->category_name }}</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="ride_package">Ride Package</label>
                    <select name="ride_package" class="form-control">
                        <option value="" selected>Choose One</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}"
                                {{ old('ride_package') == $type->id ? 'selected' : '' }}>
                                {{ $type->t_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="gps_tracking">Car GPS Tracking</label>
                <select id="gps_tracking" class="form-control" name="gps_tracking" required>
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
        </div>

    </div>
</div>
