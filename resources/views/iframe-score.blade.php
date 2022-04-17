<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Lato|Patua+One&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
	html {
		font-family: 'Lato', sans-serif;
		font-size: 16px;
		font-weight: 400;
		line-height: 1.5;
		-webkit-text-size-adjust: 100%;
		-ms-text-size-adjust: 100%;
		background: transparent;
	}
	body {
		margin:  0;
		background: transparent;
		text-align:center;
	}
	h3 {
		font-family: 'Patua One', cursive;
		font-weight: 400;
		font-size: 1.4em;
		line-height: 1.4em;
		color: #033;
		display: inline;
	}
	h4 {
		display: inline;
	}
	.container {
		box-sizing: content-box;
		max-width: 250px;
		padding-left: 15px;
		padding-right: 15px;
		padding-top: 0;
		padding-bottom: 0;
	}
	body a {
		color: #033; 
	}
	.checked {
  		color: orange;
	}
	</style>
</head>
<body>
	<div class="container">
		<h3>{{ $c->url }}</h3>
		<br>
		{{ $c->trustScore }} - {{ number_format($avg, 2) }} /5.00
		<br>
		@if( number_format($avg,2) > 0 )
		<a href="{{ $c->slug }}" target="_blank" class="full-review-link">
			{{ __( 'Check Reviews' )}}
		</a>
		@else
		<a href="{{ $c->slug }}" target="_blank" class="full-review-link">
			{{ __( 'Leave a review' )}}
		</a>
		@endif
	</div>
</body>
</html>