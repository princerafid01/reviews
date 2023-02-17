@extends( 'base' )

@section( 'content' )

    @if( session()->has( 'admin' ) AND $review->publish == 'No' )
        <div class="alert alert-danger text-center">
            {{ __('Only admin can see this preview listing.') }}
        </div><!-- /.alert alert-danger -->
    @endif

    <div class="review-single">
        <div class="review-single-bg">
            <div class="design-shape-2">
                <img src="{{ asset('images/design-shape-2.svg') }}" alt="" class="img-responsive">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="company-img">
                            <img src="{{ $review->screenshot }}" alt="" class="img-responsive" style="max-width: 100%;">
                            <span class="rating-number">
                                 {{ number_format($review->reviews()->wherePublish('Yes')->avg('rating'),1)  }}
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="review-content">
                            <h2 class="company-name">{{ $review->business_name }}</h2>
                            <h4 class="review-count">{{ $review->reviews()->wherePublish('Yes')->count() }} {{ __('reviews') }}</h4>
                            <h2 class="rating-star">
                                {!! str_repeat('<i class="fa fa-star"></i>', $review->reviews()->wherePublish('Yes')->avg('rating')) !!}
                            </h2>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <div class="company-link">
                            <div>
                                <a class="list-item" href="http://{{$review->url}}" target="_blank"
                                   rel="nofollow">
                                    <h4>
                                        <i class="fas fa-external-link-alt"></i> {{ $review->url }}
                                    </h4>
                                    {{ __('Visit Website') }}
                                </a>
                            </div>
                            <div>
                                @if($review->claimedBy)
                                    <a class="list-item list-item-2" href="#0" data-toggle="tooltip"
                                       title="{{ __('This company was claimed and manages reviews on our site') }}">
                                        <h4><i class="far fa-check-square"></i> {{ __('Claimed') }}</h4>
                                        {{ __('Company Claimed') }}
                                    </a>
                                @else
                                    <a class="list-item list-item-2" href="{{ route('companiesPlans') }}?company={{ $review->url }}" data-toggle="tooltip" title="{{ __('If you own or manage this company, you can claim it by verifying the ownership.') }}">
                                        <h4><i class="far fa-question-circle"></i> {{ __('Unclaimed') }}</h4>
                                        {{ __('Claim this company') }}
                                    </a>
                                @endif
                            </div>
                        </div><!-- /.bordered-rounded -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>


        <br>
        <div class="review-single-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">

                        @if( !$alreadyReviewed )
                            <a href="javascript:void(0);" class="btn btn-primary btn-block btn-toggle-review-form btn-review">
                                {{ __('Leave a review') }} <i class="fa fa-arrow-down"></i>
                            </a>
                        @endif

                        @if( auth()->guest() )
                            <div class="card">
                                <div style="display: inline;">
                                    {{ __( 'Please' ) }}
                                    <a class="review-login" href="{{ route('login') }}?return={{ url()->current() }}" style="text-decoration: underline">
                                        {{ __( 'Login' ) }}
                                    </a> or
                                    <a class="review-signup" href="{{ route('register') }}?return={{ url()->current() }}" style="text-decoration: underline;">
                                        {{ __( 'Signup' ) }}
                                    </a> {{ __('to leave feedback') }}
                                </div>
                            </div>
                        @else
                            @if( $alreadyReviewed )
                                <div class="alert alert-secondary">
                                    {{ __('You already reviewed this company. You can update your rating in your user panel') }}.
                                </div>
                            @else
                                @include( 'components/review-form' )
                            @endif
                        @endif
                        <div style="clear:both;height: 10px;"></div>

                        <br>

                        <!-- /.row -->
                        <div class="latest_reviews latest_reviews-2 latest_reviews-3">
                            @foreach($reviews as $r)


                                <div class="card">
                                    <div class="rating-bg d-flex align-items-center justify-content-between">
                                        <div class="rating-star star-ml">
                                            {!! str_repeat('<i class="fa fa-star"></i>', $r->rating) !!}
                                        </div>
                                        <span class="rating-number">
									{{ number_format($r->rating,1)  }}
									</span>
                                    </div>
                                    <div class="review-details d-flex">
                                        <div class="review-company text-center">
                                            <img src="{{ $r->user->profileThumb ?? asset('/public/no-img.png') }}" alt="profile pic" class="img-fluid rounded-circle">
                                            <p class="reviewer-name">{{ $r->reviewer }}</p>
                                        </div>
                                        <div class="review-text">
                                            <h5 class="text-muted">{{ $r->review_title }}</h5>
                                            <span>{!! nl2br(e($r->review_content)) !!}</span>
                                        </div>
                                    </div>
                                    <div class="rating-bg rating-bg-3 d-flex justify-content-between align-items-center">
                                        <span class="time-ago"> {{ $r->timeAgo  }} </span>
                                        <div class="upvote-thumb">
                                            @if( $r->votes()->where('ip', request()->ip())->exists() )
                                                <p class="upvote-text">{{ __('You already upvoted') }}</p>
                                            @else
                                                <a href="javascript:void(0);" class="upvote no-hover" data-review="{{ $r->id }}">
                                                    <img src="{{ asset('images/thumb.png') }}" alt="thumb icon">
                                                    <span class="upvotes" data-review="{{ $r->id }}">{{ $r->votes_count }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div><!-- ./card -->
                                <br>
                                @if( !is_null($review->claimedBy) AND auth()->check() AND $review->claimedBy == auth()->user()->id AND is_null($r->company_reply) )
                                    <div class="card card-2">
                                        <a href="javascript:void(0);" class="btn btn-danger btn-reply" data-id="{{ $r->id }}">{{ __('Reply as company') }}</a>

                                        <form method="POST" name="replyAsCompany{{ $r->id}}" style="display:none;" action="{{ route('replyAsCompany', ['review' => $r]) }}">
                                            @csrf
                                            <textarea name="replyTo_{{ $r->id }}" class="form-control" rows="5" placeholder="{{ __('ie. Thank you for sharing your thoughts') }}"></textarea>
                                            <input type="submit" name="sbReplyAsCompany{{ $r->id }}" class="btn btn-block btn-primary" value="{{ __('Send Reply') }}">
                                        </form>
                                    </div>
                                @endif

                                @if( !is_null( $r->company_reply ) )
                                    <div class="card card-2">
                                        <h6 class="company-reply">{{ __( 'Company Reply' ) }}</h6>
                                        {{ $r->company_reply }}
                                    </div>
                                @endif
                                <br>
                            @endforeach
                        </div>

                        {{ $reviews->links() }}
                    </div>
                    <!-- /.col-md-8 -->
                    <div class="col-md-4">
                        @if( $review->claimedBy )
                            <div class="card">
                                <img class="premium-badge" src="{{ asset('images/badge.png') }}" alt="premium badge">
                                <h3 class="text-center sidebar-heading">{{ __( 'Premium Company' ) }}</h3>
                            </div><!-- /.card -->
                            <br>
                        @endif

                        <div class="card">

                            <h3 class="embed-text text-center">{{ __( 'Embed Badge' )}}</h3>

                            <iframe src="{{ route('embeddedScore', ['site' => $review]) }}" frameborder="0" width="100%" height="250" scrolling="no"/></iframe>

                            <div class="site-frame">
                                <h3 class="embed-text text-center">{{ __( 'Add to your site' ) }}</h3>
                                <textarea class="form-control" rows="5"><iframe src="{{ route('embeddedScore', ['site' => $review]) }}" frameborder="0" width="100%" height="250" scrolling="no"/></iframe></textarea>
                            </div>
                        </div><!-- /.card -->
                        <br>

                        <div class="card">
                            <h3 class="sidebar-heading">{{ $review->business_name }}</h3>
                            @if( isset( $review->metadata ) && isset( $review->metadata[ 'description' ] ))
                                {{ $review->metadata[ 'description' ] }}
                            @else
                                {{ __('No description about this company yet. If you are the owner or manage this company you can claim it and add a short description.') }}
                            @endif
                        </div>
                        <!-- /.card -->
                        @if($review->location)
                            <br>
                            <div class="card">
                                <h3 class="sidebar-heading">{{ __('Location') }}</h3>
                                <p><i class="fa fa-globe"></i> {{ $review->location }}</p>
                                <!-- /.fa fa-globe -->
                            </div>
                            <!-- /.card -->
                        @endif
                        <br>
                        @if(is_null($review->claimedBy))
                            <div class="card">
                                <h3 class="sidebar-heading">{{ __('Sidebar Ads') }}</h3>
                            {!! Options::get_option( 'sideAd' ) !!}
                            <!-- /.fa fa-globe -->
                            </div>
                        @endif
                    </div>
                    <!-- /.col-md-3 -->
                    <!-- /.col-md-1 -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section( 'extraCSS' )
    @if( $review->reviews->count() )
        <script type="application/ld+json">
  {
    "@context": "https://schema.org/",
    "@type": "LocalBusiness",
    "image": "{{ $review->screenshot }}",
    "name": "{{ $review->url }}",
    "description": "{{ $review->business_name }} collection of reviews",
    "address": "{{ $review->location }}",
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "{{ $review->reviews->avg('rating') }}",
      "bestRating": "5",
      "worstRating": "1",
      "ratingCount": "{{ $review->reviews->count() }}"
    }
  }
</script>
    @endif
@endsection

@section('extraJS')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        jQuery(document).ready(function($) {

            // handle upvoting
            $( '.upvote' ).click( function() {

                var review = parseInt($( this ).data( 'review' ));

                $.getJSON( '{{ route('vote', ['review' => '/']) }}/' + review, function( r ) {

                    if (r.hasOwnProperty('error')) {
                        var oopsMsg = '{{__("Oops...")}}';
                        sweetAlert(oopsMsg, r.error, "error");
                    }else{
                        $( 'span.upvotes[data-review="' + review +'"]' ).html( r.upvotes );
                    }

                });

            });

            // handle text when hovering stars!
            $( '.star' ).hover( function() {

                    // define which star was clicked
                    var dataNo = $( this ).data( 'no' );

                    // hide all other texts
                    $( '.text-star' ).hide();

                    // reveal text under hovered star
                    $( '.text-star-' + dataNo ).show();

                },
                function() {

                });

            // add rating value into the form input
            $( '.star' ).click( function() {

                var rating = $( this ).data( 'rating' );

                $( "input[name=rating]" ).val( rating );

                console.log( 'Rating Chosen: ' + rating );

            });

            $( '.btn-toggle-review-form' ).click( function() {

                $( '.review-form-toggle' ).toggle();

            });

            $( '.btn-reply' ).click( function() {
                var replyID = $( this ).data( 'id' );
                $(this).hide();

                var replyForm = $("form[name=replyAsCompany" + replyID + "]");
                replyForm.show();



            });

        });
    </script>
@endsection
