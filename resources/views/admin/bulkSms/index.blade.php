@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid send-bulk-sms">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Send Bulk SMS</h2>
                    <div class="left-balance">
                        Left SMS: {{ $balance }}
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('admin.include.message')

                        <form method="POST" action="{{ route('admin.sms.post') }}">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label class="i-checks font-bold">
                                                <input type="radio" name="sendmethod" id="singleNumber" value="single">
                                                Single Number
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label class="i-checks font-bold">
                                                <input type="radio" name="sendmethod" id="allUser" value="allUser">
                                                All User
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label class="i-checks font-bold">
                                                <input type="radio" name="sendmethod" id="allDriver" value="allDriver">
                                                All Driver
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="radio">
                                            <label class="i-checks font-bold">
                                                <input type="radio" name="sendmethod" id="bothSender" value="bothSender">
                                                Both User & Driver
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" id="elementToToggle">
                                <label for="number" class="col-form-label">
                                    {{ __('Phone Number') }}
                                </label>
                                <div class="col-md-4 row">
                                    <input id="number" type="text" class="form-control" name="number"
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message" class="col-form-label">
                                    {{ __('Message') }}
                                </label>

                                <div class="col-md-4 row">
                                    <textarea id="message" class="form-control" name="message" required autocomplete="off"></textarea>
                                </div>
                            </div>
                            <br />
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary" onclick="return confirmSendSMS()">
                                        {{ __('Send SMS') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('extra_js')
    <script>
        $(document).ready(function() {

            $('#elementToToggle').hide();

            // Attach change event handler to radio button
            $('input[name="sendmethod"]').change(function() {
                // Check if the radio button is checked
                if ($(this).is(':checked')) {
                    // If singleNumber radio button is checked, show the element; otherwise, hide it
                    if ($(this).val() === 'single') {
                        $('#elementToToggle').show();
                    } else {
                        $('#elementToToggle').hide();
                    }
                }
            });
        });

        function confirmSendSMS() {
            // Display a confirmation dialog
            var confirmation = confirm("Are you sure you want to send the SMS?");

            // Return true if the user confirms, false otherwise
            return confirmation;
        }
    </script>
@endsection
@endsection
