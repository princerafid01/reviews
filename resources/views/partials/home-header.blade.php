@if( Options::get_option( 'homepage_header_image' ) )
<style>
.homepage-header {
    margin-top: -10px;
    background-image: url('/public/{{ Options::get_option( 'homepage_header_image' ) }}');
}
</style>
@endif
<div class="main-header bg-dark">
  <div class="header-shape">
    <img class="design-shape-1" src="{{asset('images/design-shape.svg')}}" alt="design-shape">
  </div>
  <div class="homepage-header">
      <div class="container">
        <div class="homepage-header-container text-center">
            <p class="header-link"><a href="https://www.youtube.com/watch?v=yJg-Y5byMMw" target="_blank"><i class="fa fa-play"></i></a> {{ __('How it works') }}</p>
            <h1>
              <span>
                {{ Options::get_option( 'site_description', '#1 Community Trusted Reviews' ) }}
              </span><!-- /.label label-primary -->
            </h1>
            <h3>
              <span>{{ Options::get_option( 'site_belowdescription', 'From People Like You' ) }}</span>
            </h3>
            <form class="search-form" method="GET" action="{{ route('search') }}" id="searchUser">
                <div class="row">
                  <div class="col-12">
                      <div class="d-flex justify-content-center align-items-center">
                          <input type="text" name="searchQuery" class="form-control search-input" placeholder="{{ __('Search for a company') }}" required>
                          <div class="d-flex align-items-center">
                              <div class="search-icon">
                                  <i class="fa fa-search"></i>
                              </div>
                              <input type="submit" name="searchAction" class="btn search-btn btn-block" value="{{ __('Search') }}">
                          </div>
                      </div>
                  </div>
                </div><!-- /.row -->
            </form>
        </div><!-- /.homepage-header-container -->
      </div>
  </div><!-- ./jumbotron-->
</div>