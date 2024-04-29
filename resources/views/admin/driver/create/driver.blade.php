<div class="driver-docoment -mt-0">
    <div class="heading">
        Driver Personal Information
    </div>
    <div class="row">
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" required
                    value="{{ old('first_name') }}">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" required
                    value="{{ old('last_name') }}">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="phone">Phone </label>
                    <input type="number" class="form-control" name="phone" placeholder="Phone Number" required
                        value="{{ old('phone') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter E-mail" required
                        value="" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" name="gender">
                        <option value="" selected>Choose One</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required
                        value="" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="city_id">City</label>
                    <select class="form-control" name="city_id">
                        <option value="" selected>Choose One</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ $city->id == old('city_id') ? 'selected' : '' }}>
                                {{ $city->city }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="speed">Speed</label>
                    <input type="text" class="form-control" name="speed" placeholder="Enter speed" required
                        value="{{ old('speed') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="lat">latitude</label>
                    <input type="text" class="form-control" name="lat" placeholder="Enter latitude" required
                        value="{{ old('lat') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="long">longitude</label>
                    <input type="text" class="form-control" name="long" placeholder="Enter longitude" required
                        value="{{ old('long') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="heading">Heading</label>
                    <input type="text" class="form-control" name="heading" placeholder="Enter Heading" required
                        value="{{ old('heading') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="app_token">App Token</label>
                    <input type="text" class="form-control" name="app_token" placeholder="Enter App Token"
                        required value="{{ old('first_name') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="reset_expires">Reset Expires</label>
                    <input type="date" class="form-control" name="reset_expires"
                        placeholder="Enter Reset Expires" required value="{{ old('reset_expires') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Address</label>
                <input type="text" class="form-control" name="address" />
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Driving Experience in (car)</label>
                <input type="text" class="form-control" name="address" />
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Driving Experience in (year)</label>
                <input type="text" class="form-control" name="address" />
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="licence_number">Driver Licence Number</label>
                    <input type="text" class="form-control" name="licence_number"
                        placeholder="Enter Licence Number" required value="{{ old('licence_number') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="licence_number">Driver NID Number</label>
                    <input type="text" class="form-control" name="licence_number"
                        placeholder="Enter Licence Number" required value="{{ old('licence_number') }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status">
                        <option value="" selected>Choose One</option>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active
                        </option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive
                        </option>
                    </select>
                </div>
            </div>
        </div>

    </div>
</div>