@extends( 'base' )

@section( 'content' )

<div class="container">
<div class="col-8 mx-auto card">
	<h2><i class="fas fa-exclamation"></i> {{ __('Ooops') }}</h2>
	{{ $message }}
</div><!-- /.col-8 mx-auto card -->
</div><!-- /.container div-col-8 mx-auto -->

@endsection