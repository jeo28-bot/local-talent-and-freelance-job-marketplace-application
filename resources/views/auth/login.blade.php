@extends('layouts.app')


@section('content')
<div class="container flex justify-center px-4 py-8 mx-auto">
    <div class="w-full max-w-sm sm:max-w-full lg:max-w-lg">
        <div class="">
            <div class="card  p-4 flex items-center flex-col">
                {{-- <h1 class="font-bold text-4xl mb-10">FREELANCO</h1> --}}
                <a href="{{ url('/') }}"><img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 mb-4">
                </a>
                <h1 class="titles font-bold text-2xl text-white mb-10 max-sm:text-xl">{{ __('Sign in to your acount') }}</h1>

                <div class="card-body w-full">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="max-sm:text-sm text-white ">{{ __('Email Address') }}</label>

                            <div class="mt-2">
                                <input id="email" type="email" class="mb-2 max-sm:text-sm poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback text-red-400 p_font font-light" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label for="password" class="max-sm:text-sm col-md-4 col-form-label text-md-end text-white">{{ __('Password') }}</label>

                            <div class="mt-2">
                                <input id="password" type="password" class="mb-2 max-sm:text-sm p-2  w-full form-control @error('password') is-invalid @enderror border-2 rounded-lg text-white" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback text-red-400 p_font font-light" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="flex items-center justify-between">
                                <div class="form-check flex items-center">
                                    <input class="accent-blue-400  bg-gray-700 form-check-input mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label text-white max-[640px]:text-sm" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="forgot_pass btn btn-link text-blue-400   hover:text-blue-300 max-[640px]:text-sm" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="">
                                <button type="submit" class="sign_in cursor-pointer flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-lg font-semibold text-white hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 mb-4 max-[640px]:text-sm/6">
                                    {{ __('Sign in') }}
                                </button>

                                <div class="flex items-center gap-2">
                                    <p class="p_fonts text-white max-[640px]:text-sm">Don't have an account yet? </p>

                                    <a  href="{{ route('register') }}" class="p_fonts text-blue-400 hover:text-blue-300 max-[640px]:text-sm">Sign up now.</a>

                                </div>
                                
                
                            </div>
                        </div>
                    </form>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
