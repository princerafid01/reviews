@extends( 'base' )

@section( 'content' )

    @if( session()->has( 'admin' ) AND $review->publish == 'No' )
    <div class="alert alert-danger text-center">
        {{ __('Only admin can see this preview listing.') }}
    </div><!-- /.alert alert-danger -->
    @endif

    <div class="container-fluid card inner-site-header">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ $review->screenshot }}" alt="" class="img-responsive" style="max-width: 100%;">
                </div>
                <div class="col-md-5">
                    <h2>{{ $review->business_name }}</h2>
                    <h4 class="text-muted">{{ $review->reviews->count() }} {{ __('reviews') }}</h4>
                    <h2 class="text-warning">
                        {!! str_repeat('<i class="fa fa-star"></i>', $review->reviews->avg('rating')) !!}
                        <span class="badge badge-light">
                {{ number_format($review->reviews->avg('rating'),2)  }}/5.00
            </span>
                    </h2>
                </div>
                <!-- /.col-md-5 -->
                <div class="col-md-4">
                    <div class="bordered-rounded">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a class="list-group-item" href="http://{{$review->url}}" target="_blank"
                                   rel="nofollow">
                                    <h4>
                                        <i class="fas fa-external-link-alt"></i> {{ $review->url }}
                                    </h4>
                                    {{ __('Visit Website') }}
                                </a>
                            </li>
                            <li class="list-group-item">
                                @if($review->claimedBy)
                                    <a class="list-group-item" href="#0" data-toggle="tooltip"
                                       title="{{ __('This company was claimed and manages reviews on our site') }}">
                                        <h4><i class="far fa-check-square"></i> {{ __('Claimed') }}</h4>
                                        {{ __('Company Claimed') }}
                                    </a>
                                @else
                                    <a class="list-group-item" href="{{ route('companiesPlans') }}?company={{ $review->url }}" data-toggle="tooltip" title="{{ __('If you own or manage this company, you can claim it by verifying the ownership.') }}">
                                        <h4><i class="far fa-question-circle"></i> {{ __('Unclaimed') }}</h4>
                                        {{ __('Claim this company') }}
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div><!-- /.bordered-rounded -->
                </div>
                <!-- /.col-md-9 -->
                <!-- /.col-md-3 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div><!-- /.container -->

    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                
                @if( !$alreadyReviewed )
                <a href="javascript:void(0);" class="btn btn-primary btn-block btn-toggle-review-form">
                    {{ __('Leave a review') }} <i class="fa fa-arrow-down"></i>
                </a>
                @endif
                
                @if( auth()->guest() )
                <div class="card">
                    <div style="display: inline;">
                        {{ __( 'Please' ) }} 
                        <a href="{{ route('login') }}?return={{ url()->current() }}" style="text-decoration: underline">
                            {{ __( 'Login' ) }}
                        </a> or 
                        <a href="{{ route('register') }}?return={{ url()->current() }}" style="text-decoration: underline;">
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
                @foreach($reviews as $r)
                    <div class="card">

                    <div class="row">
                    <div class="col-md-2 col-3 text-center">
                        <img src="{{ $r->user->profileThumb }}" alt="profile pic" class="img-fluid rounded-circle shadow">
                        <p class="text-muted">
                            <strong>{{ $r->reviewer }}</strong>
                            <br>
                            <span class="badge badge-light">
                                {{ $r->timeAgo  }}
                            </span>
                        </p>
                    </div><!-- /.col-md-2 col-4 -->
                    
                    <div class="col-md-10 col-9">
                        <p class="text-warning">
                            {!! str_repeat('<i class="fa fa-star"></i>', $r->rating) !!}
                            <span class="text-muted">
                                {{ number_format($r->rating,2)  }}/5.00
                            </span>
                        </p>
                        

                        <p class="text-bold">"{{ $r->review_title }}"</p>
                        <p>
                            {!! nl2br(e($r->review_content)) !!}
                        </p>
                        <p class="text-right">
                            @if( $r->votes()->where('ip', request()->ip())->exists() )
                                <small class="text-secondary">{{ __('You already upvoted') }}</small>
                            @else
                                <a href="javascript:void(0);" class="text-success upvote no-hover" data-review="{{ $r->id }}">
                                    <i class="fas fa-thumbs-up"></i> <span class="upvotes" data-review="{{ $r->id }}">{{ $r->votes_count }}</span>
                                </a>
                            @endif
                        </p>
                        <!-- /.btn btn-xs btn-success -->
                        @if( !is_null($review->claimedBy) AND auth()->check() AND $review->claimedBy == auth()->user()->id AND is_null($r->company_reply) )
                            <hr>
                            <a href="javascript:void(0);" class="btn btn-danger btn-reply" data-id="{{ $r->id }}">{{ __('Reply as company') }}</a>
                            
                            <form method="POST" name="replyAsCompany{{ $r->id}}" style="display:none;" action="{{ route('replyAsCompany', ['review' => $r]) }}">
                                @csrf 
                                <textarea name="replyTo_{{ $r->id }}" class="form-control" rows="5" placeholder="{{ __('ie. Thank you for sharing your thoughts') }}"></textarea>
                                <input type="submit" name="sbReplyAsCompany{{ $r->id }}" class="btn btn-block btn-primary" value="{{ __('Send Reply') }}">
                            </form>
                        @endif
                        @if( !is_null( $r->company_reply ) )
                        <hr>
                        <h6 class="text-warning text-bold">{{ __( 'Company Reply' ) }}</h6>
                        {{ $r->company_reply }}
                        @endif

                        </div><!-- /.col-md-10 col-8 -->
                        </div><!--./ row -->

                    </div>
                    <!-- /.card -->
                    <br>
                @endforeach

                {{ $reviews->links() }}
            </div>
            <!-- /.col-md-8 -->
            <div class="col-md-4">
                @if( $review->claimedBy )
                <div class="card">
                    <img src="{{ asset('images/premium-badge.svg') }}" alt="premium badge" height="50"> 
                    <h5 class="text-center">{{ __( 'Premium Company' ) }}</h5>
                </div><!-- /.card -->
                <br>
                @endif

                <div class="card">

                    <h3>{{ __( 'Embed Badge' )}}</h3>
                    
                    <iframe src="{{ route('embeddedScore', ['site' => $review]) }}" frameborder="0" width="250" height="150" scrolling="no"/></iframe>
                    
                    <small>
                    {{ __( 'Add to your site' ) }}
                    <textarea class="form-control" rows="5"><iframe src="{{ route('embeddedScore', ['site' => $review]) }}" frameborder="0" width="250" height="150" scrolling="no"/></iframe></textarea>
                    </small>
                </div><!-- /.card -->
                <br>

                <div class="card">
                    <h3>{{ $review->business_name }}</h3>
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
                    <h3>{{ __('Location') }}</h3>
                    <p><i class="fa fa-globe"></i> {{ $review->location }}</p>
                    <!-- /.fa fa-globe -->
                </div>
                <!-- /.card -->
                @endif
                <br>
                @if(is_null($review->claimedBy))
                <div class="card">
                    <h3>{{ __('Sidebar Ads') }}</h3>
                    {!! Options::get_option( 'sideAd' ) !!}
                    <!-- /.fa fa-globe -->
                </div>
                @endif
            </div>
            <!-- /.col-md-3 -->
            <!-- /.col-md-1 -->
        </div>
    </div>
    <!-- /.container -->

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
