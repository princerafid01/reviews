@extends( 'base' )

@section( 'content' )

<div class="container card">
	<h4>{{ __( 'We sent you an email to: ' ) }}<em>{{ $sendToEmail }}</em></h4>
	{{ __( 'Please check your email for the ownership validation link.' ) }}
</div><!-- /.container -->

@endsection