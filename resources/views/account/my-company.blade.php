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
    <a class="nav-link active" href="{{ route( 'mycompany' ) }}">{{ __('My Company') }}</a>
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
<h2>{{ __('My Company') }}</h2>
<hr>

@if($company)

<table>
	<thead>
		<tr>
			<th>{{ __('URL') }}</th>
			<th>{{ __('Name') }}</th>
			<th>{{ __('Location') }}</th>
			<th>{{ __('Manage') }}</th>
			<th>{{ __('Embed Reviews') }}</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<a href="{{ route('reviewsForSite', ['site'=> $company->url]) }}">
					{{ $company->url }}
				</a>
			</td>
			<td><strong>{{ $company->business_name }}</strong></td>
			<td>{{ $company->location }}</td>
			<td>
				<a href="{{ route('manageCompany') }}" class="btn btn-sm btn-primary">{{ __('Manage Profile') }}</a><br>
			</td>
			<td>
				<a href="{{ route('myEmbeddedCodes') }}" class="btn btn-sm btn-warning">{{ __('Embedded Codes') }}</a>
			</td>
		</tr>
	</tbody>
</table>

@else
<div class="well">
	{{ __( 'You did not claim any company.' )}}
</div><!-- /.well -->

@endif

</div><!-- /.card -->
</div><!-- /.col-10 -->


</div><!-- /.container -->

@endsection