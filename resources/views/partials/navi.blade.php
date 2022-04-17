<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
<a class="navbar-brand" href="{{ route('home') }}">

    @if($logo = Options::get_option( 'site.logo' )) 
      <img src="/public/{{ $logo }}" height="30" alt="site logo"/> 
    @else 
      <i class="far fa-star"></i>
    @endif 

  @if( Options::get_option( 'enableSiteTitle', 'Yes') == 'Yes'  )
    {{ Options::get_option( 'site_title', 'PHP Trusted Reviews' ) }}
  @endif

</a>

<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
<ul class="navbar-nav">
  <li class="nav-item @if(isset($activeNav) && ($activeNav == 'home')) active @endif">
    <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
  </li>
  <li class="nav-item @if(isset($activeNav) && ($activeNav == 'categories')) active @endif">
    <a class="nav-link" href="{{ route('browse-category', ['slug' => 'top-companies']) }}">{{ __('Browse Companies') }}</a>
  </li>
  <li class="nav-item @if(isset($activeNav) && ($activeNav == 'submit')) active @endif">
    <a class="nav-link" href="{{ route('addCompany') }}">{{ __('Add Company') }}</a>
  </li>
  @if( auth()->guest() )
  <li class="nav-item">
    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('register') }}">{{ __('Signup') }}</a>
  </li>
  @else
  <li class="nav-item">
    <a class="nav-link @if(isset($activeNav) && ($activeNav == 'account')) active @endif" href="{{ route('myaccount') }}">{{ __('My Account') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
  </li>
  @endif
</ul>
</div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>