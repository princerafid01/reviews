@extends('base')

@section('content')
        <div class="container">
            @if (!empty(Options::get_option('homeAd')))
                <div class="row">
                    <div class="col-xs-12">
                        {!! Options::get_option('homeAd') !!}
                        <br><br>
                    </div><!-- /.col-xs-12 -->
                </div><!-- /.row -->
            @endif
        </div>
        {{-- Explore Categories --}}
        <div class="explore_categories">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <h2 class="section__title">
                            {{__('Explore Categories')}}
                        </h2>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 text-right responsive-left">
                        <a class="main-btn main-btn-2" href="{{ route('categories') }}">{{ __('Browse All') }}</a>
                    </div>
                </div>

                <div class="row header-mt">
                    @foreach( $categories->take(12) as $category )
                        <div class="col-md-6 col-lg-4 margin-bottom-25">
                            <div class="card">
                                <a href="{{ url("/browse-category/$category->slug]") }}">
                                    <i class="fa fa-laptop cat-icon"></i>{{ $category->name }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="latest_reviews">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <h2 class="section__title section__title-2 text-center">
                            {{__('Latest Reviews')}}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="custom-container header-mt">
                <div class="row">
                    @foreach ($reviews->take(8) as $r)
                        <div class="col-xl-3 col-lg-4 col-md-6 margin-bottom-25">
                            <div class="card">
                                <div class="rating-bg d-flex align-items-center justify-content-between">
                                    <img src="{{ $r->user->profileThumb ?? asset('/public/no-img.png') }}" alt="profile pic" class="img-fluid rounded-circle">
                                    <div class="rating-star">
                                        {!! str_repeat('<i class="fa fa-star"></i>', $r->rating) !!}
                                    </div>
                                    <span class="rating-number">
                                    {{ number_format($r->rating,1)  }}
                            </span>
                                </div>
                                <div class="user-review">
                                    <span class="user-name">{{ $r->reviewer }}</span>
                                    <span class="reviewed-text">{{ __('reviewed') }}</span>
                                    @if (isset($r->site->slug))
                                        <a class="company-url" href="{{ $r->site->slug }}">{{ $r->site->url }}</a>
                                    @endif
                                </div>
                                <p class="review-title">"{{ $r->review_title }}"</p>
                                <p>{{ substr( $r->review_content, 0, 99 )}}...</p>
                                <div class="rating-bg rating-bg-2 d-flex justify-content-between align-items-center">
                            <span class="review-time">
                                {{ $r->timeAgo  }}
                            </span>
                                    @if (isset($r->site->slug))
                                        <a href="{{ $r->site->slug }}" class="site-link">
                                            {{ __('Read Review') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="what_we_do">
            <div class="container-fluid px-0">
                <div class="row no-gutters">
                    <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-12">
                        <div class="content-box box-1">
                            <h2 class="title">
                                {{__('Be heard')}}
                            </h2>
                            <p class="content content-2">{{__('YourValue is a review platform that’s open to everyone. Share your to help others make better choices and encourage.')}}</p>
                            <a class="main-btn main-btn-3" href="#">{{ __('What we do') }}</a>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-12">
                        <div class="content-box box-2">
                            <h2 class="title title-2">
                                {{__('Our 2022
                                Transparency
                                Report has
                                landed')}}
                            </h2>
                            <p class="content">{{__('We’re looking back on a year unlike any other. Read about how we ensure our platform’s integrity.')}}</p>
                            <a class="main-btn btn-border btn-border-2" href="#">{{ __('Take a look') }}</a>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 d-none d-xl-block">
                        <div class="content-box box-3">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="latest_reviews">
            <div class="container">
                <div class="row stories-mb">
                    <div class="col-md-12 col-xs-12 text-center">
                        <h4 class="title-sub-heading">
                            {{__('Your Stories')}}
                        </h4><h2 class="section__title section__title-2">
                            {{__('Each review has a personal story')}}
                        </h2>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10 col-md-11">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($reviews->take(6) as $r)
                                    <div class="carousel-item  {{ $loop->first ? 'active' : '' }}">
                                        <div class="margin-bottom-25">
                                            <div class="review-slide card">
                                                <div class="d-flex res-card align-items-center">
                                                    <img src="{{ $r->user->profileThumb ?? asset('/public/no-img.png') }}" alt="profile pic" class="img-fluid rounded-circle shadow">
                                                    <div class="user-review">
                                                        <div CLASS="rating-bg d-flex align-items-center justify-content-between">
                                                            <div class="rating-star star-ml">
                                                                {!! str_repeat('<i class="fa fa-star"></i>', $r->rating) !!}
                                                            </div>
                                                            <span class="rating-number">
                                             {{ number_format($r->rating,1)  }}
                                            </span>
                                                        </div>
                                                        <div class="slide-content">
                                                            <h2 class="stories_text">{{ substr( $r->review_content, 0, 99 )}}...</h2>
                                                            <span class="user-name">{{ $r->reviewer }}</span>
                                                            <span class="reviewed-text">{{ __('reviewed') }}</span>
                                                            <a class="company-url" href="{{ $r->site->slug }}">{{ $r->site->url }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="slide-arrow"><i class="fa fa-arrow-left"></i></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="slide-arrow"><i class="fa fa-arrow-right"></i></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
