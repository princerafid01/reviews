@extends('base')

@section('content')
<div class="container add-paddings">
<div class="card">
        <h3 class="heading"><i class="glyphicon glyphicon-lock"></i> {{ __('Login') }}</h3>
        
        {!! $message !!}

		<form method="POST" action="/admin/login">
		    {!! csrf_field() !!}

		    <div>
		        {{ __('User') }}
		        <input type="text" name="ausername" class="form-control">
		    </div>

		    <div>
		        {{ __('Password') }}
		        <input type="password" name="apassword" class="form-control">
		    </div>

		    <div>
		    	<br />
		        <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
		    </div>
		</form>
</div>
</div>
@endsection