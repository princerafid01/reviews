@extends( 'base' )

@section( 'content' )

<div class="container card">
	<h4>{{ __( 'Companies Plans' ) }}</h4>
	
	{{ __( 'Show that you care about your customers. Subscribe as a premium company and claim your page to take advantage of the membership.' ) }}
	
	<div class="text-inline">
	{!! __( sprintf('In order to %s signup %s simply find your company on our site and click on Claim Company', '<strong>', '</strong>' )) !!}
	</div>
	
	<hr >

    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ __('Monthly') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>
                            {{ Options::get_option('currency_symbol') }}{{ Options::get_option( 'monthlyPrice' ) }}<span class="subscript">/{{ __('month') }}</span></h1>
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                                {{ __('Manage One Company') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('Email Notifications when someone posts a new review to your company') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('Add your own company description') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('No ADS on your company page') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('Premium Company Listing') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('Reply to reviews in the name of your company') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer text-center">
                    @if( request()->has( 'company' ) )
                        <a href="{{ route('companyClaim', [ 'site' => request()->company, 'plan' => 'monthly' ]) }}" class="btn btn-success">{{ __( 'Select Monthly Plan' ) }}</a>
                    @endif
				</div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ __('Yearly') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>{{ Options::get_option('currency_symbol') }}{{ Options::get_option( 'yearlyPrice' ) }}<span class="subscript">/{{ __('year') }}</span></h1>
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                                {{ __('Manage One Company') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('Email Notifications when someone posts a new review to your company') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('Add your own company description') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('No ADS on your company page') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('Premium Company Listing') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('Reply to reviews in the name of your company') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">
                    @if( request()->has( 'company' ) )
                        <a href="{{ route('companyClaim', [ 'site' => request()->company, 'plan' => 'yearly' ]) }}" class="btn btn-success">{{ __( 'Select Yearly Plan' ) }}</a>
                    @else
                        <i class="fa fa-exclamation-triangle"></i> {{ __('Browse our site and find your company to claim and get any plan') }}
                    @endif
                 </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ __('Six Months') }}</h3>
                </div>
                <div class="panel-body">
                    <div class="the-price">
                        <h1>
                            {{ Options::get_option('currency_symbol') }}{{ Options::get_option( '6monthsPrice' ) }}<span class="subscript">/{{ __('six mo') }}</span></h1>
                    </div>
                    <table class="table">
                        <tr>
                            <td>
                                {{ __('Manage One Company') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('Email Notifications when someone posts a new review to your company') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('Add your own company description') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('No ADS on your company page') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ __('Premium Company Listing') }}
                            </td>
                        </tr>
                        <tr class="active">
                            <td>
                                {{ __('Reply to reviews in the name of your company') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="panel-footer">
                    @if( request()->has( 'company' ) )
                        <a href="{{ route('companyClaim', [ 'site' => request()->company, 'plan' => '6months' ]) }}" class="btn btn-success">{{ __( 'Select 6 Months Plan' ) }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection