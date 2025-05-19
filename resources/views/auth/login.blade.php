{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('layouts.app')

@section('title', 'Welcome to Alumni || '.env('APP_NAME'))

@section('extra_css')
    <style>
        .center-item {
            display: grid;
            place-content: center;
        }

        .limited-width {
            max-width: 500px;
        }

        .right-content {
            right: 0;
            top: 50%;
            padding: 8px;
            position: absolute;
            transform: translateY(-50%);
            border-left: 1px solid #6b7280;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="p-4 center-item">
        <form class="card p-4 limited-width" method="POST" action="{{ route('login') }}">
            @csrf
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li> 
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group mb-4">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus />
            </div>
            <div class="form-group">
                <label for="email">Password</label>
                <div class="position-relative">
                    <input class="form-control" type="password" name="password" id="password" required autofocus />
                    <div class="right-content" onclick="show_pass()">
                        <div class="eye-open d-none">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Capa_1" width="25px" height="25px" viewBox="0 0 60.254 60.254" xml:space="preserve">
                                <g>
                                    <g>
                                        <g>
                                            <path d="M29.008,48.308c-16.476,0-28.336-17.029-28.833-17.754c-0.248-0.36-0.231-0.841,0.039-1.184     c0.561-0.712,13.906-17.424,29.913-17.424c17.953,0,29.474,16.769,29.956,17.482c0.23,0.342,0.229,0.79-0.007,1.129     c-0.475,0.688-11.842,16.818-29.899,17.721C29.786,48.297,29.396,48.308,29.008,48.308z M2.267,30.028     c2.326,3.098,13.553,16.967,27.812,16.254c15.237-0.76,25.762-13.453,27.938-16.3c-2.175-2.912-12.811-16.035-27.889-16.035     C16.7,13.947,4.771,27.084,2.267,30.028z"></path>
                                        </g>
                                        <g>
                                            <path d="M30.127,37.114c-3.852,0-6.986-3.135-6.986-6.986c0-3.851,3.134-6.985,6.986-6.985s6.986,3.135,6.986,6.985     C37.113,33.979,33.979,37.114,30.127,37.114z"></path>
                                        </g>
                                        <g>
                                            <path d="M30.127,42.614c-6.885,0-12.486-5.602-12.486-12.486c0-6.883,5.602-12.485,12.486-12.485     c6.884,0,12.486,5.602,12.486,12.485C42.613,37.012,37.013,42.614,30.127,42.614z M30.127,19.641     c-5.782,0-10.486,4.704-10.486,10.486c0,5.781,4.704,10.485,10.486,10.485s10.486-4.704,10.486-10.485     C40.613,24.345,35.91,19.641,30.127,19.641z"></path>
                                        </g>
                                    </g>
                                </g>
                                </svg>
                        </div>
                        <div class="eye-close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25px" height="25px" viewBox="0 0 24 24" fill="none">
                                <path d="M4.5 15.5C7.5 9 16.5 9 19.5 15.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M16.8162 12.1825L19.5 8.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M12 10.625V7" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7.18383 12.1825L4.5 8.5" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between gap-4 mt-4">
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span class="ms-2 text-sm text-gray-600">Remember Me</span>
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Forgot Password 
                    </a>
                @endif
            </div>
            <input class="form-control bg-success text-white fw-bold" type="submit" value="Submit">
        </form>
    </div>
@endsection

@section('extra_js')
    <script>
        function show_pass() {
            let inp = document.getElementById("password");
            let open_eye = document.querySelector(".eye-open");
            let close_eye = document.querySelector(".eye-close");
            if (inp.type === "password") {
                inp.type = "text";
                open_eye.classList.remove("d-none");
                close_eye.classList.add("d-none");
            } else {
                inp.type = "password";
                open_eye.classList.add("d-none"); 
                close_eye.classList.remove("d-none");
            }
        }
    </script>
@endsection