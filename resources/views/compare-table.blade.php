@extends('base')

@section('content')
    <div class="container card">
        <h5>Compare Products</h5>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <h4 class="text-center"> Features </h4>
                <table>
                    <tr>
                        <th style="width:50%">Company</th>
                        @foreach (explode("," , Options::get_option( 'site_comparer_attributes' )) as $singleAttrHeader )
                        <th>{{$singleAttrHeader}}</th>
                        @endforeach
                    </tr>
                    @foreach ($sites as $site)
                    {{-- @foreach ($site->metadata['compare_attributes'] as $attr ) --}}
                    
                    
                    {{-- @endforeach --}}

                    <tr>
                        <td>{{$site->business_name}}</td>


                    @foreach (array_values($site->metadata['compare_attributes']) as $singleAttr )
                        <td>{{$singleAttr}}</td>
                    @endforeach
                    </tr>


                        
                    @endforeach

                </table>
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
            color: green !important;
        }

        .fa-remove {
            color: red !important;
        }
    </style>
@endsection

@section('extraJS')
@endsection
