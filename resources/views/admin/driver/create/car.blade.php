<br />
<br />
<div class="driver-docoment">
    <div class="heading">
        Car Information
    </div>
    <div class="row">

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_model_name">Car Owner Name</label>
                <input type="text" class="form-control" name="car_owner_name">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_model_name">Car Owner Bank Acc No.</label>
                <input type="text" class="form-control" name="car_owner_bank_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_model_name">Car Owner Number</label>
                <input type="text" class="form-control" name="car_owner_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_model_name">Car Model Name</label>
                <input type="text" class="form-control" name="car_model_name">
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
                <label for="car_registration_number">Car Registration Number</label>
                <input type="text" class="form-control" name="car_registration_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_color_name">Car Color Name</label>
                <input type="text" class="form-control" name="car_color_name">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_engine_number">Car Engine Number</label>
                <input type="text" class="form-control" name="car_engine_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_chassize_number">Car Chassize Number</label>
                <input type="text" class="form-control" name="car_chassize_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_bluebook_number">Car Bluebook Number</label>
                <input type="text" class="form-control" name="car_bluebook_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_route_permit_number">Car Route Permit Number</label>
                <input type="text" class="form-control" name="car_route_permit_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_chassize_number">Car Fleetness Number</label>
                <input type="text" class="form-control" name="car_fleetness_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_chassize_number">Car Fitness Ensuring Date</label>
                <input type="text" class="form-control" name="car_fitness_ensuring_date">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_chassize_number">Car Fitness Expired Date</label>
                <input type="text" class="form-control" name="car_fitness_expired_date">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_insurance_number">Car Insurance Number</label>
                <input type="text" class="form-control" name="car_insurance_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_tax_token_number">Car Tax Token Number</label>
                <input type="text" class="form-control" name="car_tax_token_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_tax_token_number">Car Owner Mobile Number</label>
                <input type="text" class="form-control" name="car_owner_mobile_number">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="car_tax_token_number">Car Owner NID number</label>
                <input type="text" class="form-control" name="car_owner_nid_number">
            </div>
        </div>


        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="ride_service">Ride Service</label>
                    <select class="form-control" name="services">
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
