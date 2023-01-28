@extends( 'base' )

@section( 'content' )

<div class="container ptb">
	<h4>{{ $title }}</h4>
	{!! $content !!}
</div><!-- /.container -->

@endsection