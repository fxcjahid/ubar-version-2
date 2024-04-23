@extends('admin.layouts.layout')
@section('extra_css')
    ;
@endsection
@section('section')
    <div class="container-fluid">
        <div class="row column_title">
            <div class="col-md-12">
                <div class="page_title">
                    <a href="{{ route('admin.dashboard') }}"><i
                        class="fa fa-arrow-left black"></i>Back</a>
                    <h2>Category wise Data</h2>
                </div>
            </div>
        </div>
        <div class="row column1">
            @foreach ($cates as $item)
            <div class="col-md-6 col-lg-3">
                <div class="full counter_section margin_bottom_30">
                    <div class="couter_icon">
                        <div>
                            <i class="fa fa-motorcycle yellow_color"></i>
                        </div>
                    </div>
                    <div class="counter_no">
                        <div>
                            <p class="total_no">10</p>
                            <p class="head_couter">{{$type}}</p>
                            <p class="head_couter text-primary"><b>{{$item->category_name}}</b></p>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
    </div>
@endsection
@section('extra_js')
@endsection
