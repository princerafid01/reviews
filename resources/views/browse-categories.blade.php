@extends( 'base' )

@section( 'content' )
	<div class="explore_categories">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<h2 class="section__title">
						{{__('All Categories')}}
					</h2>
				</div>
			</div>
			<div class="row header-mt">
				<div class="col-xs-12">
					{!! Options::get_option( 'catAd' ) !!}
					<hr>
				</div>
				@foreach( $categories as $c )
					<div class="col-md-4 margin-bottom-25">
						<div class="card">
							<a href="{{ route('browse-category', ['slug' => $c->slug]) }}">
								<i class="fa fa-laptop cat-icon"></i>{{ $c->name }}
							</a>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>

@endsection