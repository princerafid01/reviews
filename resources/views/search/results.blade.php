@extends( 'base' )

@section( 'content' )

    <div class="ptb">
        <div class="container">
            <div class="text-center">
                <h3>
                    {{ __('Search Results: ') }}<span class="text text-success">"{{ request('searchQuery') }}"</span>
                </h3>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-xs-12">
                    <div class="latest_reviews latest_reviews-2 res-latest-review">
                        @forelse( $sites as $site )
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
                                        <div class="bg-rating d-flex justify-content-center align-items-center">
                                            <a href="{{ route( 'reviewsForSite', [ 'site' => $site ] ) }}" class="site-link">{{ __('Read all reviews for') . ' ' . $site->url }}</a>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- ./card -->
                        @empty
                            <div class="text text-success">
                                <h5>
                                    {{ __('Sorry, no matching results found') }}
                                </h5>
                            </div>
                            <!-- /.col-md-4 -->

                            @component('components/add-new-site') @endcomponent;
                            <!-- /.well -->
                            <br>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

