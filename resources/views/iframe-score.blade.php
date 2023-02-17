<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Lato|Patua+One&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		html {
			font-family: 'Poppins', sans-serif;
			font-size: 18px;
			font-weight: 500;
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
			font-family: 'Poppins', sans-serif;
			font-weight: 500;
			font-size: 22px;
			color: #FFFFFF;
		}
		.main-btn{
			font-size: 16px;
			font-weight: 500;
			color: #9DCA96;
			text-align: center;
			padding: 15px 25px;
			background: #3B654E;
			border-radius: 5px;
			position: relative;
			z-index: 1;
			overflow: hidden;
			transition: .6s;
			display: inline-block;
		}
		.main-btn:hover{
			color: #FFFFFF;
		}
		.site-iframe {
			background: #6FAD84;
			padding: 2px 10px 30px 10px;
			border-radius: 5px;
		}
		.site-iframe h3{
			margin-bottom: 20px;
		}
		.trust-text {
			background: #FFFFFF;
			color: #3B654E;
			border-radius: 5px 0 0 5px;
			padding: 15px 35px;
		}
		.trust-score {
			background: #CDE5BD;
			color: #3B654E;
			border-radius: 0 5px 5px 0;
			padding: 15px 35px;
		}
		.trust-content{
			display: flex;
			justify-content: center;
		}
		body a {
			color: #FFFFFF;
			text-decoration: none;
		}
		.checked {
			color: orange;
		}
	</style>
</head>
<body>
<div class="site-iframe">
	<h3>{{ $c->url }}</h3>
	<div class="trust-content">
		<div class="trust-text">{{ $c->trustScore }}</div>
		<div class="trust-score">{{ number_format($avg, 1) }}</div>
	</div>
	@if( number_format($avg,1) > 0 )
		<a class="main-btn" href="{{ $c->slug }}" target="_blank" class="full-review-link"><i class="fa fa-arrow-right"></i>
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