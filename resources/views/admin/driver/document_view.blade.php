@extends('admin.layouts.layout')
@section('extra_css')
@endsection
@section('section')
    <div class="container-fluid driver-document-viewer">
        <div class="row">
            <div class="col-md-12">
                <div class="white_shd full">
                    <div class="full graph_head">
                        <div class="heading1 margin_0">
                            <h2>Driver Document View</h2>
                        </div>
                    </div>
                    <div class="table_section padding_infor_info">

                        @foreach ($items as $item)
                            @empty(!$item['url'])
                                <div class="image-holader">
                                    <div class="title">{{ $item['name'] }}</div>
                                    <div class="imager">
                                        <img src="{!! url($item['url']) !!}">
                                    </div>
                                </div>
                            @endempty
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
