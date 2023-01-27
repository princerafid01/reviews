@extends('base')

@section('content')
    <div class="browse_companies">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="card sidebar_content">

                        <h5>{{ __('Filters') }}</h5>
                        <form method="GET">

                            <span class="sidebar_title">{{ __('Category') }}</span><hr/>
                            <div class="cat_title">
                                <a href="{{ route('browse-category', ['slug' => 'top-companies']) }}">
                                    {{ __('Top Companies') }}
                                </a>
                            </div>

                            @foreach ($all_categories as $c)
                                @empty($c->parent_id)
                                    <div class="cat_title">
                                        <a href="{{ route('browse-category', ['slug' => $c->slug]) }}">
                                            {{ $c->name }}
                                        </a>
                                    </div>

                                    @foreach ($c->children as $sub_cat)
                                        <div class="cat_sub_title">
                                            <a href="{{ route('browse-category', ['slug' => $sub_cat->slug]) }}" style="margin-left: 20px">
                                                - {{ $sub_cat->name }}
                                            </a>
                                        </div>

                                        @foreach ($sub_cat->children as $sub_sub_cat)
                                            <div class="cat_sub_sub_title">
                                                <a href="{{ route('browse-category', ['slug' => $sub_sub_cat->slug]) }}" style="margin-left: 40px">
                                                    - {{ $sub_sub_cat->name }}
                                                </a>
                                            </div>

                                        @endforeach
                                    @endforeach
                                @endempty
                            @endforeach

                            @if (is_null($location))
                                <span class="sidebar_title">{{ __('Location') }}</span>
                                <input type="text" name="location" class="form-control sidebar_input" id="city_region">
                                <input type="hidden" name="lati" id="lati">
                                <input type="hidden" name="longi" id="longi">
                            @else
                                <span class="tag tag-primary"><i class="fa fa-globe"></i> {{ $location }} <a
                                            href="{{ $resetURL }}"
                                            class="text-primary">[{{ __('Reset Location') }}]</a></span>
                                <br>
                            @endif
                            <br>

                            <span class="sidebar_title">{{ __('Sort By') }}</span>
                            <ul class="list-unstyled sidebar_radio">
                                <li><input type="radio" name="sortBy" value="default"
                                           @if (!request()->has('sortBy') or request('sortBy') == 'default') checked="" @endif> {{ __('Default') }}</li>
                                <li><input type="radio" name="sortBy" value="best"
                                           @if (request('sortBy') == 'best') checked @endif> {{ __('Best Rated') }}</li>
                                <li><input type="radio" name="sortBy" value="worst"
                                           @if (request('sortBy') == 'worst') checked @endif> {{ __('Worst Rated') }}</li>
                                <li><input type="radio" name="sortBy" value="most-reviews"
                                           @if (request('sortBy') == 'most-reviews') checked @endif> {{ __('Most Reviewed') }}</li>
                                <li><input type="radio" name="sortBy" value="least-reviews"
                                           @if (request('sortBy') == 'least-reviews') checked @endif> {{ __('Least Reviewed') }}</li>
                            </ul><!-- /.list-unstyled -->

                            <span class="sidebar_title">{{ __('No. of reviews') }}</span>
                            <ul class="list-unstyled sidebar_radio">
                                <li><input type="radio" name="reviewsCount" value="0"
                                           @if (!request()->has('reviewsCount') or request('reviewsCount') == '0') checked @endif> {{ __('All') }}</li>
                                <li><input type="radio" name="reviewsCount" value="25"
                                           @if (request('reviewsCount') == 25) checked @endif> 25+</li>
                                <li><input type="radio" name="reviewsCount" value="50"
                                           @if (request('reviewsCount') == 50) checked @endif> 50+</li>
                                <li><input type="radio" name="reviewsCount" value="100"
                                           @if (request('reviewsCount') == 100) checked @endif> 100+</li>
                                <li><input type="radio" name="reviewsCount" value="250"
                                           @if (request('reviewsCount') == 250) checked @endif> 250+</li>
                                <li><input type="radio" name="reviewsCount" value="500"
                                           @if (request('reviewsCount') == 500) checked @endif> 500+</li>
                                <li><input type="radio" name="reviewsCount" value="1000"
                                           @if (request('reviewsCount') == 1000) checked @endif> 1k+</li>
                            </ul><!-- /.list-unstyled -->

                            <span class="sidebar_title">{{ __('Company Status') }}</span>
                            <ul class="list-unstyled sidebar_radio">
                                <li><input type="radio" name="companyStatus" value="all"
                                           @if (!request()->has('companyStatus') or request('companyStatus') == 'all') checked @endif> {{ __('All') }}</li>
                                <li><input type="radio" name="companyStatus" value="claimed"
                                           @if (request('companyStatus') == 'claimed') checked @endif> {{ __('Claimed') }}</li>
                                <li><input type="radio" name="companyStatus" value="unclaimed"
                                           @if (request('companyStatus') == 'unclaimed') checked @endif> {{ __('Unclaimed') }}</li>
                            </ul><!-- /.list-unstyled -->

                            <input type="submit" name="sbFilter" value="{{ __('Apply Filters') }}" class="btn btn-primary btn-filter">
                        </form>
                    </div>
                </div><!-- /.col-md-4 col-xs-12 -->

                <div class="col-md-8 col-xs-12">
                    <div class="card top-heading">
                        <h5>{{ __('Showing companies in') . ' ' . $category->name }}</h5>

                        <div class="col-xs-12">
                            {{ Options::get_option('catAd') }}
                        </div>

                    </div><!-- ./card -->
                    <br>
                    <div class="latest_reviews latest_reviews-2 res-latest-review">
                        @foreach( $sites as $site )
                            <div class="card">
                                <div class="rating-bg d-flex align-items-center justify-content-between">
                                    <div class="rating-star star-ml">
                                        {!! str_repeat('<i class="fa fa-star"></i>', $site->reviews()->wherePublish('Yes')->avg('rating')) !!}
                                    </div>
                                    <span class="rating-number">
									{{ number_format($site->reviews()->wherePublish('Yes')->avg('rating'),1)  }}
									</span>
                                </div>
                                <div class="review-details d-flex">
                                    <div class="review-company">
                                        <h5>{{ $site->business_name }}</h5>
                                        <span class="text-muted">
									<i class="fa fa-globe"></i> {{ $site->location }}
                                            @if( !is_null($location) )
                                                ( {{ number_format($site->distance,2) }} {{ __( 'miles distance' )}} )
                                            @endif
									</span>
                                        <h6 class="text-muted">{{ $site->reviews()->wherePublish('Yes')->count() }} {{ __('reviews') }}</h6>
                                    </div>
                                    <div class="review-text">
                                        @forelse( $site->reviews()->take(1)->orderBy('id','DESC')->get() as $r )
                                            <h5 class="text-muted">{{ $r->review_title }}</h5>
                                            <span>{{ substr( $r->review_content, 0, 70 )}}....</span>
                                        @empty
                                            <h5 class="text-muted"> {{ __( 'No reviews yet' )}}</h5>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="bg-rating d-flex justify-content-between align-items-center">
                                    <a href="{{ route( 'reviewsForSite', [ 'site' => $site ] ) }}" class="site-link">{{ __('Read all reviews for') . ' ' . $site->url }}</a>
                                    <label>
                                        <input type="checkbox" class="compare_checkbox" name="compare" value="default"
                                               data-url="{{ $site->url }}" data-name="{{ $site->business_name }}"> Compare
                                    </label>
                                </div>

                            </div><!-- ./card -->
                            <br>
                        @endforeach

                        {{ $sites->appends([ 'sortBy' => request('sortBy'),
                                             'reviewsCount' => request('reviewsCount'),
                                             'lati' => request('lati'),
                                             'longi' => request('longi'),
                                             'location' => request('location'),
                                             'companyStatus' => request( 'companyStatus' ) ])
                                             ->links() }}
                    </div>
                </div>
            </div>
        </div><!-- /.container card -->
    </div>

    {{-- making a moduler Site Comparer --}}
    <div class="site-comparer">
        <div class="container">
            <div class="row pb-3">
                <div class="col-md-6 col-8">
                    <h4 class="title-compare">Compare Product</h4>
                </div>
                <div class="col-md-6 col-4">
                    {{-- <button id="compareTop" class="btn float-right"> --}}
                    <i class="fa fa-arrow-down fa-2x compare-arrow  float-right"></i>
                    {{-- </button> --}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="product-wrapper ">
                        <div class="product-main  d-inline-block">

                        </div>
                        <div class="product-placeholder d-inline-block">

                        </div>
                    </div>


                </div>
                <div class="col-md-6 mt-2">
                    <a href="#" class="btn main-btn compare-btn float-right">Compare Now</a><br />
                    <button class="btn main-btn btn-border mt-2 remove-btn  float-right " id="removeAllProduct">Remove
                        All</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraJS')
    <script src="https://maps.google.com/maps/api/js?libraries=places&key={{ Options::get_option('mapsApiKey') }}">
    </script>
    <script>
        // Address autocomplete
        var placeSearch, autocomplete;
        var componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name'
        };

        function initialize() {
            // Create the autocomplete object, restricting the search
            // to geographical location types.
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {HTMLInputElement} */
                (document.getElementById('city_region')), {
                    types: ['geocode']
                });
            // When the user selects an address from the dropdown,
            // populate the address fields in the form.
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                fillInAddress();
            });
        }

        // [START region_fillform]
        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

            console.log(place.address_components);


            // get latitute and longitude
            var lati = place.geometry.location.lat();
            var longi = place.geometry.location.lng();

            document.getElementById('lati').value = lati;
            document.getElementById('longi').value = longi;

            // get city and state
            var ac = place.address_components;
            var city = ac[1].long_name;
            var state = ac[3].long_name;

            document.getElementById('city').value = city;
            document.getElementById('state').value = state;

            // console.log( "City: " + city + ", State: " + state );

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            // Get each component of the address from the place details
            // and fill the corresponding field on the form.
            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                    console.log(addressType + "=" + val);
                }
            }
        }
        // [END region_fillform]

        // [START region_geolocation]
        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = new google.maps.LatLng(
                        position.coords.latitude, position.coords.longitude);
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
        // [END region_geolocation]

        $(document).ready(function() {
            initialize();
        });
    </script>
    <script src="{{ asset('js/compare.js') }}"></script>
@endsection

@section('extraCSS')
    <link href="{{ asset('css/compare.css') }}" rel="stylesheet">
@endsection
