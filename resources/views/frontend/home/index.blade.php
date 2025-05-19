@extends('layouts.app')

@section('title', 'Home || ' . env('APP_NAME'))

@section('extra_css')
    <style>
        .counter-wrapper { 
            background-size: cover;
            position: relative;
            background-color: #333;
            background-position: center center;
            background-image: url("{{ asset('frontend_assets/img/counter-bg.jpg') }}");
        }

        .counter-wrapper .count {
            font-size: 40px;
            font-weight: bold;
        }

        .counter-wrapper::after {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            content: '';
            position: absolute;
            background: rgba(0, 0, 0, 0.5);
        }

        .counter-wrapper .counter-inner {
            z-index: 2;
            position: relative;
        }

        .counter-wrapper .count-icon {
            font-size: 48px;
        }

        @media (max-width:576px) {
            .margin-sm {
                margin: 5px;
            }

            .image-control-sm {
                height: 90%;
                width: 90%;
            }

            .flex-direction-sm {
                flex-direction: column-reverse !important;

            }

            .text-start-sm {
                text-align: start;
            }
        }

        @media (min-width:768px) and (max-width:992px) {

            .image-control-md {
                height: 300px;
                width: 90%;
            }


        }

        @media (min-width: 993px) {
            .image-control-lg {
                height: 80%;
                width: 90%;
            }

            .text-end-lg {
                text-align: end;
            }
        }

        .tab-pane {
            display: none;
            opacity: 0;
            transform: translateX(-30px);
            transition: all 0.4s ease;
        }

        .tab-pane.tab-active {
            display: block;
            opacity: 1;
            transform: translateX(0);
        }

        .fade-in-left {
            animation: fadeInLeft 0.5s ease forwards;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

    </style>
@endsection

@section('content')
    <!-- Icon shape start -->
    <div class="icon-shape">
        <img class="hero-shape" src="{{ asset('frontend_assets/img/logo/hero-icon.png') }}" alt="logo-shape-icon" loading="lazy">
    </div>
    <!-- Icon shape end -->

    <!-- popup massage-->
    @if($popupNotices->count() > 0)
        @foreach($popupNotices as $popupNotice)
            <div class="pop-up-massage">
                <div class="absolute-box">
                    <div class="container center-item">
                        <div class="position-relative">
                            <img class="banner-img"
                                src="{{ asset($popupNotice->image) }}"
                                alt="Popup Notice"
                                loading="lazy">
                            <button class="btn close-btn text-white" onclick="this.closest('.pop-up-massage').remove()">
                                <i class="bi bi-x"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- popup massage end-->

    <!-- full screen logo -->
    <div class="logo-box"></div>
    <!-- Hero Section Start -->
    <section id="hero" class="hero section dark-background">
        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-item active">
                <img src="{{ asset('frontend_assets/img/slider-1.jpg') }}" alt="hero-carousel" loading="lazy">
                <div class="container">
                    <h4>University, Bangladesh</h4>
                    <a href="{{ route('frontend.about') }}" class="btn-get-started">Read More</a>
                </div>
            </div>
            <div class="carousel-item active">
                <img src="{{ asset('frontend_assets/img/slider-2.jpg') }}" alt="hero-carousel" loading="lazy">
                <div class="container">
                    <h4>Classrooms</h4>
                    <a href="{{ route('frontend.about') }}" class="btn-get-started">Read More</a>
                </div>
            </div>
            @if ($getSlider->count() > 0)
                @foreach ($getSlider as $ind => $slider)
                    <div class="carousel-item {{ $ind == 1 ? 'active' : '' }}">
                        <img src="{{ asset($slider->gallery_image) }}" alt="hero-carousel" loading="lazy">
                        <div class="container">
                            <h4>{{ $slider->title }}</h4>
                            <a href="{{ route('frontend.about') }}" class="btn-get-started">Read More</a>
                        </div>
                    </div>
                @endforeach
            @endif
            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>
            <ol class="carousel-indicators"></ol>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- About Section Start -->
    <section id="about" class="about section position-relative">
        <img class="l-shape-absolute" src="{{ asset('frontend_assets/img/logo/shape-1.png') }}" alt="Shape 1" loading="lazy">
        <img class="rb-shape-absolute" src="{{ asset('frontend_assets/img/logo/shape-2.png') }}" alt="Shape 2" loading="lazy">
        <div class="container">
            <!-- VC’s Massage -->
            <div class="card mb-4">
                <div data-aos="zoom-out" data-aos-delay="200" class="row card-body">
                    <div class="col-sm-6 col-md-4">
                    <img class="honour-member-profile" src="{{ asset($message->vc_image ?? 'frontend_assets/img/profile.png') }}" alt="VC's Image" loading="lazy">
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h2 class="mb-3">VC’s Massage</h2>
                        <p class="m-0">
                            {!! $message->vc_message ?? 'No message available' !!}
                        </p>
                    </div>
                </div> 
            </div>           
            <!-- Alumni President Massage -->
            <div class="card mb-4">
                <div data-aos="zoom-out" data-aos-delay="200" class="row flex-column-reverse flex-sm-row card-body">
                    <div class="col-sm-6 col-md-8">
                        <h2 class="mb-3">Alumni President Massage</h2>
                        <p class="m-0">
                            {!! $message->president_message ?? 'No message available' !!}
                        </p>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <img class="honour-member-profile" src="{{ asset( $message->president_image ?? 'frontend_assets/img/profile.png') }}" alt="VC's Image" loading="lazy">
                    </div>
                </div>
            </div>            
            <!-- Advisor Massage -->
            <div class="card mb-4">
                <div data-aos="zoom-out" data-aos-delay="200" class="row card-body">
                    <div class="col-sm-6 col-md-4">
                        <img class="honour-member-profile" src="{{ asset($message->advisor_image ?? 'frontend_assets/img/profile.png') }}" alt="VC's Image" loading="lazy">
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h2 class="mb-3">Advisor Massage</h2>
                        <p class="m-0">
                            {!! $message->advisor_message ?? 'No message available' !!}
                        </p>
                    </div>
                </div>
            </div>            
        </div>
    </section>
    <!-- About Section End -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">
        <!-- Section Title -->
        <div class="container section-title position-relative" data-aos="fade-up">
            <img class="l-shape-absolute" src="{{ asset('frontend_assets/img/logo/shape-2.png') }}" alt="Shape 2" loading="lazy">
            <h2>Important Links</h2>
            <p>
                Access essential university services, alumni resources, and tools with just a single click
            </p>
        </div>
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-0 clients-wrap">
                @foreach($links as $link)
                    <div class="col-xl-3 col-md-4 client-logo">
                        <a href="{{ $link->link }}" target="_blank">
                            <img src="{{ asset('imp_link_img/' . $link->img_path) }}" class="img-fluid"
                                alt="Important Link" loading="lazy" width="60%">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Clients Section End -->

    <!-- Counter Section Start -->
    <section class="counter-wrapper">
        <div class="counter-inner">
            <div class="container">
                <div class="row g-0">
                    <div class="col-6 col-lg-4">
                        <div class="py-5 text-center text-white">
                            <div>
                                <i class="bi bi-people count-icon"></i>
                            </div>
                            <div class="py-2 count">
                                <span id="count1">435</span>+
                            </div>
                            <div>
                                Total Member
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="py-5 text-center text-white">
                            <div>
                                <i class="bi bi-newspaper count-icon"></i>
                            </div>
                            <div class="py-2 count">
                                <span id="count2">170</span>+
                            </div>
                            <div>
                                Total Notice
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4">
                        <div class="py-5 text-center text-white">
                            <div>
                                <i class="bi bi-calendar2-week count-icon"></i>
                            </div>
                            <div class="py-2 count">
                                <span id="count3">56</span>+
                            </div>
                            <div>
                                Total Events
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- Gallery Section Start -->
    <section class="gallery py-md-5 py-4 position-relative">
        <img class="rb-shape-absolute" src="{{ asset('frontend_assets/img/logo/shape-1.png') }}" alt="Shape 1" loading="lazy">
        <div class="container">
            <div class="container section-title" data-aos="fade-up">
                <h2>Our Gallery</h2>
                <p>
                    Explore unforgettable memories, alumni events, and cherished moments captured throughout the university
                    journey
                </p>
            </div>
            <div class="gallery-btn-group">
                <a href="javascript:void(0);" onclick="showTab(this, 'all')" class="btn gallery-btn-toggler active">Show All</a>
                <a href="javascript:void(0);" onclick="showTab(this, 'events')" class="btn gallery-btn-toggler">Events</a>
                <a href="javascript:void(0);" onclick="showTab(this, 'labs')" class="btn gallery-btn-toggler">Labs</a>
                <a href="javascript:void(0);" onclick="showTab(this, 'classroom')" class="btn gallery-btn-toggler">Classroom</a>
            </div>

            <div id="gallery-content">
                {{-- Show All Tab --}}
                <div class="tab-pane fade-in-left tab-active" id="tab-all">
                    <div class="row py-4">
                        @foreach ($showAll as $item)
                            <div class="col-md-4 col-sm-6 gallery-box {{ $item->type == 1 ? 'events' : ($item->type == 2 ? 'labs' : 'classroom') }}">
                                <div class="gallery-img">
                                    <img class="rounded gallery-item" src="{{ asset($item->gallery_image) }}" alt="{{ $item->title }}" loading="lazy">
                                    <button onclick="openLightbox(this)" class="btn gallery-overlay">
                                        <i class="ri-play-circle-line"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {!! $showAll->links() !!}
                    </div>
                </div>

                {{-- Events Tab --}}
                <div class="tab-pane fade-in-left" id="tab-events">
                    <div class="row py-4">
                        @foreach ($event as $item)
                            <div class="col-md-4 col-sm-6 gallery-box events">
                                <div class="gallery-img">
                                    <img class="rounded gallery-item" src="{{ asset($item->gallery_image) }}" alt="{{ $item->title }}" loading="lazy">
                                    <button onclick="openLightbox(this)" class="btn gallery-overlay">
                                        <i class="ri-play-circle-line"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {!! $event->links() !!}
                    </div>
                </div>

                {{-- Labs Tab --}}
                <div class="tab-pane fade-in-left" id="tab-labs">
                    <div class="row py-4">
                        @foreach ($lab as $item)
                            <div class="col-md-4 col-sm-6 gallery-box labs">
                                <div class="gallery-img">
                                    <img class="rounded gallery-item" src="{{ asset($item->gallery_image) }}" alt="{{ $item->title }}" loading="lazy">
                                    <button onclick="openLightbox(this)" class="btn gallery-overlay">
                                        <i class="ri-play-circle-line"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {!! $lab->links() !!}
                    </div>
                </div>

                {{-- Classroom Tab --}}
                <div class="tab-pane fade-in-left" id="tab-classroom">
                    <div class="row py-4">
                        @foreach ($classroom as $item)
                            <div class="col-md-4 col-sm-6 gallery-box classroom">
                                <div class="gallery-img">
                                    <img class="rounded gallery-item" src="{{ asset($item->gallery_image) }}" alt="{{ $item->title }}" loading="lazy">
                                    <button onclick="openLightbox(this)" class="btn gallery-overlay">
                                        <i class="ri-play-circle-line"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {!! $classroom->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gallery Section End -->
@endsection

@section('extra_js')
    <script>
        $(document).ready(function() {
            let counted = false;

            function isInViewport(elem) {
                const elementTop = elem.offset().top;
                const elementBottom = elementTop + elem.outerHeight();
                const viewportTop = $(window).scrollTop();
                const viewportBottom = viewportTop + $(window).height();
                return elementBottom > viewportTop && elementTop < viewportBottom;
            }

            function counter(id, start, end, duration) {
                if (start === end) {
                    document.querySelector(id).innerText = end;
                    return;
                }

                let current = start;
                const range = end - start;
                const increment = end > start ? 1 : -1;
                const stepTime = Math.abs(Math.floor(duration / range));
                const obj = document.querySelector(id);

                const timer = setInterval(function () {
                    current += increment;
                    obj.innerText = current;
                    if (current === end) {
                        clearInterval(timer);
                    }
                }, stepTime);
            }

            function loadCounts() {
                $.ajax({
                    url: "{{ route('frontend.home.counts') }}",
                    method: 'GET',
                    success: function (res) {
                        counter("#count1", 0, res.members, 1000);
                        counter("#count2", 0, res.notices, 1500);
                        counter("#count3", 0, res.events, 1500);
                    }
                });
            }

            $(window).on('scroll load', function () {
                if (!counted && isInViewport($('#count1'))) {
                    loadCounts();
                    counted = true;
                }
            });
        });

        $(window).on('scroll', function () {
            var scrollY = $(this).scrollTop();
            var halfScreenHeight = $(window).height() / 2;

            if (scrollY >= halfScreenHeight) {
                $('#header').removeClass('header-home');
            } else {
                $('#header').addClass('header-home');
            }
        });

        function showTab(el, type) {
            $('.gallery-btn-toggler').removeClass('active');
            $(el).addClass('active');

            $('.tab-pane').removeClass('tab-active');
            $('#tab-' + (type === 'all' ? 'all' : type)).addClass('tab-active');
        }
    </script>
@endsection
