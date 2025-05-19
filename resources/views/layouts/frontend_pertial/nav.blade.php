<!-- Main nav -->
<header id="header" class="header d-flex align-items-center sticky-top {{ Route::is('index')? 'header-home': '' }}">
    <div class="container position-relative d-flex align-items-center z-1000">
        <a href="{{ route('index') }}" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <img src="{{ asset('frontend_assets/img/logo/logo.png') }}" alt="Logo" loading="lazy">
            {{-- <h1 class="sitename">{{ env('APP_NAME') }}</h1><span>.</span> --}}
        </a>
        <nav id="navmenu" class="navmenu">
            <ul>
                <li>

                    <a href="{{ route('index') }}" class="active">Home</a>
                </li>
                <li>
                    <a href="{{ route('frontend.about') }}">About</a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('frontend.member') }}"><span>Member Directory</span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i>

                    </a>
                    <ul id="member-directory-menu" class="dropdown-menu"></ul>
                </li>
                <li class="dropdown">
                    <a href="">
                        <span>Committee</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul>
                        <li class="dropdown">
                            <a href="javascript: void(0);"> <span>Present Committee</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul style="right: auto; left:100%;">
                                <li><a href="{{ route('frontend.present.committee') }}">
                                        Executive Committee
                                    </a></li>
                                <li><a href="{{ route('frontend.committee.advisor') }}">
                                        Advisor Committee
                                    </a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="javascript: void(0);">
                                <span>Previous Committee</span> <i class="bi bi-chevron-down toggle-dropdown">



                                </i>
                            </a>
                            <ul id="previous-committee-menu" style="right: auto; left:100%;"></ul>
                        </li>
                    </ul>
                </li>
                @if (Auth::guest())
                    <li>
                        <a href="{{ route('frontend.notice') }}">Notice</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.event') }}">Event</a>
                    </li>
                    <li>
                        <a href="{{ route('frontend.publication') }}">Research & Publication</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="javascript: void(0);">
                            <span>Notice</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('frontend.notice') }}">All Notice</a>
                            </li>
                            <li>
                                <a href="{{ route('MyNotice') }}">My Notice</a>
                            </li>
                            @can('Can access create notice')
                            <li>
                                <a href="javascript: void(0);" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Create Notice</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript: void(0);">
                            <span>Event</span> <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            <li>
                                <a href="{{ route('frontend.event') }}">All Event</a>
                            </li>
                            <li>
                                <a href="{{ route('MyEvent') }}">My Event</a>
                            </li>
                            {{-- @if (Auth::user()->role == '1') --}}
                            @can('Can access view registration')
                                <li>
                                    <a href="{{ route('registerEvent') }}">View Registration</a>
                                </li>
                            @endcan
                            {{-- @endif --}}
                            @can('Can access create event')
                            <li>
                                <a href="javascript: void(0);" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal1">Create Event</a>
                            </li>
                            @endcan
                        </ul>
                    </li>
                @endif
                @if (Auth::guest())
                    <li>
                        <a href="{{ route('login') }}">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Alumni Register</a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="{{ route('frontend.about') }}">
                            <span>
                                @if ($getForProfile == null)
                                    Person
                                @else
                                    {{ $getForProfile->name }}
                                @endif
                            </span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                            <span>
                                @if ($countUser > 0)
                                    {{ $countUser }}
                                @endif
                            </span>
                        </a>
                        <ul>
                            @can('Can access profile')
                                <li><a href="{{ route('Profile.Show') }}">Profile</a></li>
                            @endcan

                            @can('Can access dashboard')
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            @endcan

                            @can('Can access frontend')
                                <li><a href="{{ route('frontend') }}">Frontend</a></li>
                            @endcan
                            <li>
                                <a href="javascript: void(0);" id="logout">Logout</a>
                                <form action="{{ route('logout') }}" method="post" id="logout_form">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <div class="header-social-links">
            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            {{-- <a href="#" class="instagram"><i class="bi bi-instagram"></i></a> --}}
            {{-- <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a> --}}
        </div>
    </div>
</header>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const memberFilterBaseUrl = "{{ route('frontend.member.filter', ['id' => '__ID__', 'category_name' => '__CATEGORY_NAME__']) }}";
</script>

<script>
    $(document).ready(function () {
        $.ajax({
            url: "{{ route('frontend.member.directory') }}",
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                buildMenu(data);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching menu:", error);
            }
        });

        function buildMenu(categories) {
            const menu = $('#member-directory-menu');
            menu.empty(); // Clear existing items

            categories.forEach(category => {
                if (!category.subcategories.length) {
                    menu.append(`<li><a href="${memberFilterBaseUrl.replace('__ID__', category.id).replace('__CATEGORY_NAME__', encodeURIComponent(category.name))}">${category.name}</a></li>`);
                } else {
                    let subMenuHtml = $('<ul>').css({ left: '100%', right: 'auto' });

                    category.subcategories.forEach(sub => {
                        let subSubHtml = '';
                        if (sub.sub_subcategories.length) {
                            subSubHtml = $('<ul>').css({ left: '100%', right: 'auto' });
                            sub.sub_subcategories.forEach(subSub => {
                                const filterUrl = memberFilterBaseUrl
                                    .replace('__ID__', subSub.id)
                                    .replace('__CATEGORY_NAME__', encodeURIComponent(subSub.name));
                                subSubHtml.append(`<li><a href="${filterUrl}">${subSub.name}</a></li>`);
                            });
                        }

                        let subItem = $(`
                            <li class="dropdown">
                                <a href="javascript:void(0);">
                                    ${sub.name}
                                    ${sub.sub_subcategories.length ? '<i class="bi bi-chevron-down toggle-dropdown"></i>' : ''}
                                </a>
                            </li>
                        `);

                        if (sub.sub_subcategories.length) {
                            subItem.append(subSubHtml);
                        }

                        subMenuHtml.append(subItem);
                    });

                    const parentItem = $(`
                        <li class="dropdown">
                            <a href="javascript:void(0);">
                                ${category.name}
                                <i class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
                        </li>
                    `);

                    parentItem.append(subMenuHtml);
                    menu.append(parentItem);
                }
            });
        }

        $.ajax({
            url: "{{ route('frontend.previous.committees.json') }}",
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                buildPreviousCommitteeMenu(data);
            },
            error: function (xhr, status, error) {
                console.error("Error fetching previous committees:", error);
                $('#previous-committee-menu').html('<li><a href="#">No Committee Found</a></li>');
            }
        });

        function buildPreviousCommitteeMenu(data) {
            const menu = $('#previous-committee-menu');
            menu.empty();

            if ($.isEmptyObject(data)) {
                menu.append('<li><a href="#">No Committee Found</a></li>');
                return;
            }

            $.each(data, function (committeeType, committees) {
                if (committees.length === 0) return;

                let subMenu = $('<ul style="right: auto; left:100%;"></ul>');

                $.each(committees, function (i, committee) {
                    subMenu.append(`<li><a href="${committee.route}">${committee.year_range} Committee</a></li>`);
                });

                const parentLi = $(`
                    <li class="dropdown">
                        <a href="javascript: void(0);">
                            <span>${committeeType} Committee</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                    </li>
                `);

                parentLi.append(subMenu);
                menu.append(parentLi);
            });
        }
    });

    $("#logout").on("click", function() {
        $("#logout_form").submit();
    })
</script>
