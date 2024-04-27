@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title ">
                    <h2>Send Bulk SMS</h2>
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
                                <label for="number" class="col-form-label">
                                    {{ __('Phone Number') }}
                                </label>
                                <div class="col-md-4 row">
                                    <input id="number" type="text" class="form-control" name="number" required
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
        function confirmSendSMS() {
            // Display a confirmation dialog
            var confirmation = confirm("Are you sure you want to send the SMS?");

            // Return true if the user confirms, false otherwise
            return confirmation;
        }
    </script>
@endsection
@endsection
