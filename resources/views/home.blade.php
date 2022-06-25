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
        {{-- Explore Categories --}}
        <div class="home-categories">
            <div class="row my-5">
                <div class="col-md-12">
                    <h3 class="float-left">Explore categories</h3>

                    <a href="#" class="btn btn-primary text-white float-right p-2">
                        View All
                    </a>
                </div>
            </div>

            <div class="cat-wrapper owl-carousel owl-theme">
                <div class="row item">
                    @foreach ($categories->take(9) as $category)
                        <div class="col-md-4 singleCat margin-bottom-25">
                            <a href="#" class="card"> <i
                                    class="fa fa-{{ $category->icon }}"></i>{{ $category->name }}</a>
                        </div>
                    @endforeach
                </div>


                <div class="row item ">
                    @foreach ($categories->skip(9)->take(PHP_INT_MAX) as $category)
                        <div class="col-md-4 singleCat margin-bottom-25">
                            <a href="#" class="card"> <i
                                    class="fa fa-{{ $category->icon }}"></i>{{ $category->name }}</a>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>


    <div class="review-wrapper  owl-carousel owl-theme">
        @php
            $time_to_loop = ceil($reviews->count() / 3);
            $take = 3;
            $skip = 0;
        @endphp

        @for ($i = 0; $i < $time_to_loop; $i++)
            <div class="row item">
                @foreach ($reviews->skip($skip)->take($take) as $r)
                    <div class="col-md-4  margin-bottom-25">
                        <div class="card">
                            <p class="text-warning">
                                {!! str_repeat('<i class="fa fa-star"></i>', $r->rating) !!}
                                <span class="text-muted">
                                    {{ number_format($r->rating, 2) }}/5.00
                                </span>
                            </p>
                            <div class="row">
                                <div class="col-4 col-md-3">
                                    <img src="{{ $r->user->profileThumb ?? asset('/public/no-img.png') }}"
                                        alt="profile pic" class="img-fluid rounded-circle shadow">
                                </div><!-- /.col-xs-6 col-md-1 -->
                                <div class="col-8 col-md-8 text-muted">
                                    <strong>{{ $r->reviewer }}</strong> {{ __('reviewed') }}<br>
                                    @if (isset($r->site->slug))
                                        <a href="{{ $r->site->slug }}">{{ $r->site->url }}</a>
                                    @endif
                                </div><!-- /.col-xs-6 col-md-11 -->
                            </div><!-- /.row -->
                            <br>
                            <p class="text-bold">"{{ $r->review_title }}"</p>
                            <p>{{ substr($r->review_content, 0, 99) }}...</p>
                            <p class="justify-content-between">
                                <span class="text-muted float-left">
                                    {{ $r->timeAgo }}
                                </span>
                                @if (isset($r->site->slug))
                                    <a href="{{ $r->site->slug }}" class="btn btn-sm inline btn-success float-right">
                                        &raquo; {{ __('Read Review') }}
                                    </a>
                                @endif
                            </p>
                            <!-- /.btn btn-xs btn-success -->
                        </div>
                    </div>
                    <!-- /.card -->
                @endforeach
            </div>
            @php
                $skip += $take;
            @endphp
        @endfor
    </div>

    <div class="about bg-white" style="margin-top: 80px;padding: 100px 0 50px 0">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8">
                            <h1>Be Heard</h1>
                            <p class="text-bold mb-5 mt-5">Trustpilot is a review platform that’s open to everyone. Share
                                your experiences to help others make better choices and encourage companies to up their
                                game.</p>

                            <a href="#"
                                style="border-color:black!important; text-decoration:none; border-radius: 40px;"
                                class="btn-lg p-4 btn-light border "> What we do</a>

                        </div>
                    </div>

                </div>

                <div class="col-md-6  p-5" style="background-color: #ffc107; margin-top: -13%;">
                    <div class="col-md-8">
                        <h1>Our 2022 Transparency Report has landed</h1>
                        <p class="text-bold mb-5 mt-4">We’re looking back on a year unlike any other. Read about how we
                            ensure our platform’s integrity.</p>
                        <a href="#" style="text-decoration:none; border-radius: 40px;"
                            class="btn-lg p-4 btn-dark text-white"> Take a look</a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="top-review" style="padding: 70px 0 35px 0">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="text-center">Your stories</h6>
                    <h1 class="text-center">Each review has a personal story</h1>
                    <div class="row">
                        <div class="col-md-12" style="margin: 0 auto">
                            <div class="top-review-inner owl-carousel owl-theme">
                            @foreach ($reviews->take(3) as $review)
                                <div class="item bg-white p-5">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        <i class="fa fa-star 3x"></i>                                     
                                    @endfor
                                    <h1 style="font-size: 40px">“{{$review->review_content}}”</h1>
                                    <small> {{$review->review_title}} </small>
                                </div>
                            @endforeach
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>




    </div>

    {{-- <footer>
        <div class="container">

        </div>
    </footer> --}}


    <!-- /.row -->
@endsection

@section('extraCSS')
    <link href="{{ asset('css/owl.carousel.min.css') }}" rel="stylesheet">
@endsection

@section('extraJS')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script>
        $('.cat-wrapper').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });

        $('.top-review-inner').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });



        $('.review-wrapper').owlCarousel({
            loop: true,
            items: 1,
            margin: 20,
            nav: false,
            stagePadding: 0,
            autoplay: true,
            slideTransition: 'linear',
            autoplaySpeed: 28000,
            smartSpeed: 6000,
            center: true,
            autoplayHoverPause: true,
            stopOnHover: true
        });


        $('.review-wrapper').trigger('play.owl.autoplay', [1000]);

        function setSpeed() {
            $('.review-wrapper').trigger('play.owl.autoplay', [6000]);

        }
        setTimeout(setSpeed, 1000);
    </script>
@endsection
