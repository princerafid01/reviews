@extends( 'base' )

@section( 'content' )

<div class="container">
<div class="row">
<div class="col-10 mx-auto">
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'myaccount' ) }}">{{ __('My Reviews') }}</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'myprofile' ) }}">{{ __('My Profile') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'mycompany' ) }}">{{ __('My Company') }}</a>
  </li>

  <li class="nav-item">
    <a class="nav-link active" href="{{ route( 'mybilling' ) }}">{{ __('My Billing') }}</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" href="{{ route( 'logout' ) }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('Log Out') }}</a>
  </li>
</ul>
</div><!-- /.col-10 card -->

<div class="col-10 mx-auto">
<div class="card">
<h2>{{ __('My Billing') }}</h2>
<hr>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>{{ __('ID') }}</th>
      <th>{{ __('Company') }}</th>
      <th>{{ __('Plan') }}</th>
      <th>{{ __('Price') }}</th>
      <th>{{ __('Start Date') }}</th>
      <th>{{ __('Status') }}</th>
    </tr> 
  </thead>
  <tbody>
    @foreach( $subscriptions as $s )
    <tr>
      <td>{{ str_replace('sub_', '', $s->subscription_id) }}</td>
      <td>
        {{ $s->site->business_name }}<br>
        <a href="{{ route('reviewsForSite', ['site'=> $s->site->url]) }}">
          {{ $s->site->url }}
        </a>
      </td>
      <td>{{ ucfirst( $s->plan )}}</td>
      <td>{{ Options::get_option( 'currency_symbol' ) . $s->subscription_price }}</td>
      <td>{{ date('jS F Y', $s->subscription_date) }}</td>
      <td>
          {{ $s->subscription_status }}<br>
          @if( 'Active' == $s->subscription_status )
          <small>
            <a class="text-danger" href="{{ route('subscriptionCancel', [ 'id' => $s->id ]) }}" onclick="return confirm('{{ __('Are you sure you want to cancel the subscription plan') }}?')">
              {{ __('Cancel') }}
            </a>
          </small>
          @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table><!-- /.table table-bordered -->


</div><!-- /.card -->
</div><!-- /.col-10 -->


</div><!-- /.container -->

@endsection