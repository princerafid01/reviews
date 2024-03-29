@extends( 'base' )

@section( 'content' )

<div class="container ptb">
<div class="row">
<div class="col-10 mx-auto">
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="{{ route( 'myaccount' ) }}">{{ __('My Reviews') }}</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'myprofile' ) }}">{{ __('My Profile') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'mycompany' ) }}">{{ __('My Company') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'mybilling' ) }}">{{ __('My Billing') }}</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'logout' ) }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
  </li>
</ul>
</div><!-- /.col-10 card -->

<div class="col-10 mx-auto">
<div class="card">
<h4>{{ __('Update Review') }}</h4>

<div class="star-source">
  <svg>
    <symbol id="star" viewBox="153 89 106 108">   
      <polygon id="star-shape" stroke="url(#grad)" stroke-width="5" fill="currentColor" points="206 162.5 176.610737 185.45085 189.356511 150.407797 158.447174 129.54915 195.713758 130.842203 206 95 216.286242 130.842203 253.552826 129.54915 222.643489 150.407797 235.389263 185.45085"></polygon>
    </symbol>
</svg>
</div><!-- ./star-source -->

<form method="post" action="{{ route('updateMyReview', ['reviewId' => $r->id]) }}">
@csrf

 <input type="hidden" name="rating">
 <div class="star-container">
  <input type="radio" name="star" id="five">
  <label for="five">
    <svg class="star" data-no="five" data-rating="5" data-toggle="modal" data-target="#review-modal">
      <use xlink:href="#star"/>
    </svg>
    <div class="text-star text-star-five">
    Great
   </div>
  </label>
  <input type="radio" name="star" id="four">
  <label for="four">
    <svg class="star" data-toggle="modal" data-target="#review-modal" data-rating="4" data-no="four">
      <use xlink:href="#star"/>
    </svg>
    <div class="text-star text-star-four">
    Good
   </div>
  </label>
  <input type="radio" name="star" id="three">
  <label for="three">
    <svg class="star" data-toggle="modal" data-target="#form-modal" data-no="three" data-rating="3">
      <use xlink:href="#star"/>
    </svg>
    <div class="text-star text-star-three">
    Okay
   </div>
  </label>
  <input type="radio" name="star" id="two">
  <label for="two">
    <svg class="star" data-toggle="modal" data-target="#form-modal" data-no="two" data-rating="2">
      <use xlink:href="#star" />
    </svg>
    <div class="text-star text-star-two">
    Subpar
   </div>
  </label>
  <input type="radio" name="star" id="one">
  <label for="one">
   <svg class="star" data-toggle="modal" data-target="#form-modal" data-no="one" data-rating="1">
    <use xlink:href="#star" />
   </svg>
   <div class="text-star text-star-one">
    Bad
   </div>
  </label>
</div><!-- ./star-container -->

<div class="form-group">
<label>{{ __('Review Title') }}</label>
<input class="form-control" type="text" name="review_title" value="{{ $r->review_title }}" required="required">
</div>
<div class="form-group">
<label>{{ __( 'Description' ) }}</label>
<textarea class="form-control" style="height: 180px;" name="review_content" required="required">{{ $r->review_content }}</textarea>
</div>
<button type="submit" name="sbReview" class="btn btn-primary btn-block">{{ __('Post Review') }}</button>

</form>

</div><!-- /.card -->
</div><!-- /.col-10 -->


</div><!-- /.container -->

@endsection

@section( 'extraJS' )
<script>
$( function(  ) {
// add rating value into the form input
        $( '.star' ).click( function() {

            var rating = $( this ).data( 'rating' );
            
            $( "input[name=rating]" ).val( rating );

            console.log( 'Rating Chosen: ' + rating );

        });
});
</script>
@endsection