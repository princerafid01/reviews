@extends( 'base' )

@section( 'content' )

<div class="container ptb">
<div class="row">
<div class="col-10 mx-auto">
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'myaccount' ) }}">{{ __('My Reviews') }}</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'myprofile' ) }}">{{ __('My Profile') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link active" href="{{ route( 'mycompany' ) }}">{{ __('My Company') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'mybilling' ) }}">{{ __('My Billing') }}</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'logout' ) }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
  </li>
</ul>
</div><!-- /.col-10 card -->

<div class="col-10 mx-auto">
<div class="card">
<h2>{{ __('My Embedded Codes') }}</h2>
<hr>

<div class="row">
<div class="col-xs-12 col-lg-6">
<h4>{{ __('Customize appearance') }}</h4>
<form method="POST" id="iframe-customizer">
	@csrf
	<dl>
		<dt>{{ __('General Background Color') }}</dt>
		<dd><input type="text" name="generalBG" class="form-control cp" value="{{ Options::get_option('generalBG_' . $company->id ) }}"></dd>
		<dt>{{ __('Testimonial Background Color') }}</dt>
		<dd><input type="text" name="testiGB" class="form-control cp" value="{{ Options::get_option('testiGB_' . $company->id ) }}"></dd>
		<dt>{{ __('General Font Color') }}</dt>
		<dd><input type="text" name="generalFC" class="form-control cp" value="{{ Options::get_option('generalFC_' . $company->id ) }}"></dd>
		<dt>{{ __('Testimonial Font Color') }}</dt>
		<dd><input type="text" name="testiFC" class="form-control cp" value="{{ Options::get_option('testiFC_' . $company->id ) }}"></dd>
		<dt>{{ __('URL Font Color') }}</dt>
		<dd><input type="text" name="urlFC" class="form-control cp" value="{{ Options::get_option('urlFC_' . $company->id ) }}"></dd>
	</dl>
</form>
</div><!-- /.col-xs-12 col-lg-6 -->

<div class="col-xs-12 col-lg-6">
<h4>{{ __('Preview') }}</h4>
{!! '<iframe id="preview" src="'.route('embedded', [ 'site' => $company ]).'" frameborder="0" width="450" height="350" scrolling="no"></iframe>' !!}
</div><!-- ./preview -->

</div><!-- ./row -->
<br>

<h4>{{ __('My Code') }}</h4>
<div class="card card-body bg-warning">
	{{ __('Copy & Paste this code where you want the reviews to show') }}
</div><!-- /.well -->
<br>
<textarea class="form-control" rows="3">
{{ '<iframe src="'.route('embedded', [ 'site' => $company ]).'" frameborder="0" width="450" height="350" scrolling="no"></iframe>' }}
</textarea>

@endsection

@section( 'extraCSS' )
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css">
@endsection

@section( 'extraJS' )
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js"></script>

<script>
	$(function() {
		$( '.cp' ).colorpicker();

		$('#iframe-customizer').change(function(el) {

			var inpField = el.target.name;
			var inpValue = el.target.value;
			var token = $( 'input[name=_token]' ).val();

			$.post( '/account/setCompanyWidgetColors', {'field': inpField, 'value':inpValue, '_token': token }, function(resp) {
				
				if( typeof resp.success !== undefined ) {
					$( '#preview' ).attr( 'src', function ( i, val ) { return val; });
				}

				if( resp.error !== undefined ) {
					alert( resp.error );
				}

			});

		});

	});

</script>
@endsection