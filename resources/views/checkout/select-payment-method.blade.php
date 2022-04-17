@extends( 'base' )

@section( 'content' )

<div class="container">
	<div class="row align-justify">
		<div class="col-md-8 offset-md-2 card">
			<h4>{{ __( 'Select Payment Method') }}</h4>
			<h5>{{ __( sprintf( 'Payment Amount: %s/%s', $amount, ucfirst($plan) ) )}}
			<br>
			<hr>

			@if( 'Yes' == Options::get_option( 'stripeEnable' ) )
			<a href="/checkout/credit-card" class="btn btn-primary btn-lg">
				<i class="fa fa-credit-card payment-icons"></i> {{ __('Credit Card') }}</a>
			@endif
			@if( 'Yes' == Options::get_option( 'paypalEnable' ) )
			<a href="/checkout/paypal" class="btn btn-warning paypalSubmit btn-lg">
				<i class="fab fa-paypal"></i> {{ __('PayPal') }}</a>
			@endif
								
		</div><!-- /.col-md-6 -->
	</div><!-- /.row -->
</div><!-- /.container -->

@endsection