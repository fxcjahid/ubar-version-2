@extends('admin.layouts.layout')
@section('extra_css')
    <style>
        .password,
        #add-picture-btn {
            display: none
        }
    </style>
@endsection
@section('section')
    <div class="container-fluid driver-docoment-viewer create-driver">
        <div class="row">
            <div class="col-md-12">
                <div class="white_shd full margin_bottom_30">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Driver Information : {{ $user->name }}</h2>
                        </div>
                    </div>
                    <div class="padding_infor_info">
                        @include('admin.driver.document.driver')

                        @include('admin.driver.document.car', ['services' => $services])

                        @include('admin.driver.document.files')

                        <br>

                        <div class="float-right">
                            <button type="submit" class="btn btn-success">update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inputFiles = document.querySelectorAll("input");
            inputFiles.forEach(function(inputFile) {
                inputFile.disabled = true;
            });
            var inputSelect = document.querySelectorAll("select");
            inputSelect.forEach(function(inputSelect) {
                inputSelect.disabled = true;
            });
        });
    </script>
@endsection
