<div class="driver-docoment -mt-0">
    <div class="heading">
        Driver Personal Information
    </div>
    <div class="row">
        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" name="first_name" placeholder="Enter First Name" required
                    value="{{ $user->first_name ?? null }}">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" name="last_name" placeholder="Enter Last Name" required
                    value="{{ $user->last_name ?? null }}">
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="Phone Number" required
                        value="{{ $user->phone ?? null }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter E-mail" required
                        value="{{ $user->email ?? null }}" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" name="gender" required>
                        <option value="" {{ $user->userInfo->gender == '' ? 'selected' : '' }}>Choose One</option>
                        <option value="male" {{ $user->userInfo->gender == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ $user->userInfo->gender == 'female' ? 'selected' : '' }}>Female
                        </option>
                        <option value="others" {{ $user->userInfo->gender == 'others' ? 'selected' : '' }}>Others
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6 password">
            <div class="form-group">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required
                        value="" autocomplete="off">
                </div>
            </div>
        </div>

        {{-- <div class="col-6 col-sm-12 col-md-6 col-xl-6">
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
                    <label for="heading">Heading</label>
                    <input type="text" class="form-control" name="heading" placeholder="Enter Heading" required
                        value="{{ old('heading') }}">
                </div>
            </div>
        </div> --}}

        {{-- <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="emergency_number">Emergency Number</label>
                    <input type="text" class="form-control" name="emergency_number"
                        placeholder="Enter Emergency Number" required value="{{ old('emergency_number') }}">
                </div>
            </div>
        </div> --}}

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address"
                    value="{{ $user->driverInfo->address ?? null }}" />
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="experience_in_car">Driving Experience in (car)</label>
                <input type="text" class="form-control" name="experience_in_car"
                    value="{{ $user->driverInfo->experience_in_car ?? null }}" />
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <label for="experience_in_year">Driving Experience in (year)</label>
                <input type="text" class="form-control" name="experience_in_year"
                    value="{{ $user->driverInfo->experience_in_year ?? null }}" />
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="licence_number">Driver Licence Number</label>
                    <input type="text" class="form-control" name="licence_number" placeholder="Enter Licence Number"
                        required value="{{ $user->driverInfo->licence_number ?? null }}">
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-12 col-md-6 col-xl-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="nid_number">Driver NID Number</label>
                    <input type="text" class="form-control" name="nid_number" placeholder="Enter Licence Number"
                        required value="{{ $user->driverInfo->nid_number ?? null }}">
                </div>
            </div>
        </div>

        {{-- <div class="col-6 col-sm-12 col-md-6 col-xl-6">
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
        </div> --}}

    </div>
</div>
