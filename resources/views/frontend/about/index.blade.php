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
    <!-- About Section Start -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row position-relative">
                <div class="col-lg-7 about-img" data-aos="zoom-out" data-aos-delay="200">
                    @if($aboutSection && $aboutSection->image)
                        <img src="{{ asset($aboutSection->image) }}" alt="About Image" class="img-fluid">
                    @else
                        <img src="{{ asset('frontend_assets/img/about.jpg') }}" alt="Default About Image" class="img-fluid">
                    @endif
                </div>

                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="inner-title">Our Legacy, Our Community</h2>
                    <div class="our-story">
                        <h4 class="text-white">Est 2025</h4>
                        <h3 class="text-white">Our Story</h3>
                        <p>
                            {!! $aboutSection->details ?? 'Content will be available soon.' !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

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
    <section class="gallery py-md-5 py-4">
        <div class="container">
            <div class="container section-title" data-aos="fade-up">
                <h2>Our Gallery</h2>
                <p>
                    Explore unforgettable memories, alumni events, and cherished moments captured throughout the university journey
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

        
        function showTab(el, type) {
            $('.gallery-btn-toggler').removeClass('active');
            $(el).addClass('active');

            $('.tab-pane').removeClass('tab-active');
            $('#tab-' + (type === 'all' ? 'all' : type)).addClass('tab-active');
        }
    </script>
@endsection
