@extends( 'base' )

@section( 'content' )

    <div class="container ptb">
        <div class="row justify-content-center">
            <div class="col-md-10 col-xs-12">
		<div class="card">
			<h2>{{ __('Submit Company') }}</h2>
			{{ __( "Didn't find the company you're looking for?" )}}	
			<hr>

			<form method="POST" action="{{ route('storeCompany') }}">
			@csrf

			<label>{{ __('Website URL') }}</label>
			<input type="text" name="url" value="{{ old('url') }}" placeholder="{{ __('http://example.com') }}" class="form-control" required="required">
			
			<br>
			<label>{{ __('Company Name') }}</label>
			<input type="text" name="name" value="{{ old('name') }}" placeholder="{{ __('Example Ltd') }}" class="form-control" required="required">

			<br>
			<label>{{ __('Category') }}</label>

			<select class="form-control" name="category_name" id="category_id" required="required">
				{{-- <option value="" @if(old('category_id') == $c->id) selected @endif>@if(old('category_id') == $c->id) {{$c->name}} @endif</option> --}}
				<option value="" selected>Select Category</option>

			{{-- @foreach( $categories as $c )
				<option value="{{ $c->id }}" @if(old('category_id') == $c->id) selected @endif>{{ $c->name }}</option>
			@endforeach --}}
			</select>
			<br>


      <select class="form-control" name="sub_category_name" id="sub_category_id" required="required">
        <option value="" selected>Select Sub Category</option>
			</select>
			<br>

      <select class="form-control" name="sub_sub_category_name" id="sub_sub_category_id" required="required">
        <option value="" selected>Select Sub Sub Category</option>
			</select>

      
			<br>
			<label>{{ __('Location') }}</label>
			<input type="text" name="city_region" id="city_region" placeholder="{{ __('Company Location') }}"  required="required" autocomplete="off" class="form-control" value="{{ old('city_region') }}">
				
			</select>

      @foreach (explode(",",$comparer_options) as $option)
          <label>{{ ucwords($option) }}</label>
          <input type="text" name="option_name" value="{{ old('option_name') }}" placeholder="" class="form-control" required="required">
        
      @endforeach

			<input type="hidden" name="lati" id="lati" value="{{ old('lati') }}">
			<input type="hidden" name="longi" id="longi" value="{{ old('longi') }}">

			<br>
			<input type="submit" name="sbNewReviewItem" class="btn btn-block btn-primary" value="{{ __('Submit New Company') }}">

			</form>
		</div>
		</div>		
		</div>
	</div><!-- /.container card -->
   
@endsection

@section( 'extraJS' )

 <script src="https://maps.google.com/maps/api/js?libraries=places&key={{ Options::get_option('mapsApiKey') }}"></script>
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
          /** @type {HTMLInputElement} */(document.getElementById('city_region')),
          { types: ['geocode'] });
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

      console.log( place.address_components );


      // get latitute and longitude
      var lati = place.geometry.location.lat();
      var longi = place.geometry.location.lng();

      document.getElementById('lati').value = lati;
      document.getElementById('longi').value = longi;

      // get city and state
      var ac = place.address_components;
      var city = ac[ 1 ].long_name;
      var state = ac[ 3 ].long_name;

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
          console.log( addressType + "=" + val );
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

    function dropdownLocationInitialize() {
      let dataCategories = @json($json_encoded_categories);
      let categories = @json($categories);
      dataCategories = JSON.parse(dataCategories);
      console.log(categories);


      var subjectSel = document.getElementById("category_id");
      var topicSel = document.getElementById("sub_category_id");
      var chapterSel = document.getElementById("sub_sub_category_id");
      for (var x in dataCategories) {
        // const slug = categories.find(t => t.name === x)?.slug
        subjectSel.options[subjectSel.options.length] = new Option(x,x);
      }
      subjectSel.onchange = function() {
       //empty Chapters- and Topics- dropdowns
        chapterSel.length = 1;
        topicSel.length = 1;
        //display correct values
        for (var y in dataCategories[this.value]) {
          topicSel.options[topicSel.options.length] = new Option(y, y);
        }
      }
      topicSel.onchange = function() {
       //empty Chapters dropdown
        chapterSel.length = 1;
        //display correct values
        var z = dataCategories[subjectSel.value][this.value];
        for (var i = 0; i < z.length; i++) {
          chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
        }
      }
    }
    // [END region_geolocation]

    $( document ).ready( function() {
    	initialize();
      dropdownLocationInitialize();
    });
    </script>

@endsection
