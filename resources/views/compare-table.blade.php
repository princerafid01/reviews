@extends('base')

@section('content')
    <div class="ptb">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <h2 class="section__title section__title-2 text-center">
                        {{__('Compare Products')}}
                    </h2>
                </div>
            </div>
            <div class="row header-mt">
                <div class="col-xs-12 col-md-12">
                    <div class="compare_product d-flex align-items-end justify-content-center">

                        {{-- @foreach ($site->metadata['compare_attributes'] as $attr ) --}}
                        {{-- @endforeach --}}

                        <div class="feature">
                            <div class="feature_list">
                                @foreach (explode("," , Options::get_option( 'site_comparer_attributes' )) as $singleAttrHeader )
                                    <p>{{$singleAttrHeader}}</p>
                                @endforeach
                            </div>
                        </div>
                        <div class="feature_section d-flex justify-content-center">
                            @foreach ($sites as $site)
                                <div class="{{ $loop->count==3 ? 'feature_item res-3' : ($loop->count==2 ? 'feature_item res-2' : 'feature_item res-1') }} ">
                                    <div>
                                        <h5 class="feature_title">{{$site->business_name}}</h5>
                                    </div>
                                    <div class="feature_list">
                                        <p>None for 365 Days</p>
                                        <p>Full Month</p>
                                        <p><i class="fa fa-check"></i></p>
                                        <p>Locally Staffed</p>
                                        <p>21-Day Grace Period</p>
                                        <p>7 Day Money Back</p>
                                        <p><i class="fa fa-check"></i></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{--@foreach (array_values($site->metadata['compare_attributes']) as $singleAttr )
                        <td>{{$singleAttr}}</td>
                    @endforeach--}}

                </div>
            </div>
        </div>
    </div>
@endsection
@section('extraCSS')
    <style>
        table {
            border-collapse: collapse !important;
            border-spacing: 0 !important;
            width: 100% !important;
            border: 1px solid #ddd !important;
        }

        th,
        td {
            text-align: center !important;
            padding: 16px !important;
            border: 1px solid #ddd !important;

        }

        th:first-child,
        td:first-child {
            text-align: left !important;
        }

        tr:nth-child(even) {
            background-color: #fff !important;
        }

        .fa-check {
            color: #9dca96; !important;
        }

        .fa-remove {
            color: #9dca96 !important;
        }
    </style>
@endsection

@section('extraJS')
@endsection
