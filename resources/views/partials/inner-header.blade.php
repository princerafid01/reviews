<div class="container-fluid inner-search {{request()->is('reviews/*') ? 'inner-search-2' : ''}}">
<div class="container">
  <form method="GET" action="{{ route('search') }}" id="searchUser">
  <div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-center">
          <input type="text" name="searchQuery" class="form-control search-input" placeholder="{{ __('Search for a company') }}" required>
          <div class="d-flex align-items-center">
              <div class="search-icon">
                  <i class="fa fa-search"></i>
              </div>
              <input type="submit" name="searchAction" class="btn search-btn" value="{{ __('Search') }}">
          </div>
        </div>
    </div>
    </div><!-- /.row -->
  </form>
</div>
</div><!-- /.container-fluid -->