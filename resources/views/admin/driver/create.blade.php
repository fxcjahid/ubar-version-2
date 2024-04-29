@extends('admin.layouts.layout')
@section('extra_css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('section')
    <div class="container-fluid create-driver">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <span>
                        <h2>Add Driver</h2>
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
                            <h2>Create Driver</h2>
                        </div>
                    </div>
                    @include('admin.include.message')
                    <div class="padding_infor_info">
                        <form action="{{ route('admin.driver.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @include('admin.driver.create.driver')

                            @include('admin.driver.create.car', ['services' => $services])

                            @include('admin.driver.create.document')

                            <br />
                            <div class="col-10 col-sm-12">
                                <div class="form-group">
                                    <input type="checkbox" class="form-control" name="agree" required checked>
                                    <label for="agree">Terms & Conditions or BRTC and license agree</label>
                                </div>
                            </div>

                            <div class="float-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('extra_js')
    <script>
        // Counter for dynamic input field IDs
        let pictureInputCounter = 2; // Starting from 2 because we already have one input field

        // Function to add a new picture input field
        function addPictureInput() {
            if (pictureInputCounter <= 6) {
                const pictureInputContainer = document.getElementById('picture-input-container');

                // Create new label
                const label = document.createElement('label');
                label.setAttribute('for', `car_extra_image_0${pictureInputCounter}`);
                label.textContent = `Car Extra Image 0${pictureInputCounter}`;

                // Create new input field
                const inputField = document.createElement('input');
                inputField.setAttribute('type', 'file');
                inputField.setAttribute('class', 'form-control');
                inputField.setAttribute('name', `car_extra_image_0${pictureInputCounter}`);

                // Append label and input field to container
                pictureInputContainer.appendChild(document.createElement('br')); // Add a line break for spacing
                pictureInputContainer.appendChild(label);
                pictureInputContainer.appendChild(inputField);

                // Increment counter for next input field
                pictureInputCounter++;
            } else {
                // Alert user that maximum limit reached
                alert('Maximum limit of 6 picture inputs reached.');
            }
        }

        // Event listener for Add Picture Input button
        document.getElementById('add-picture-btn').addEventListener('click', addPictureInput);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
@endsection
