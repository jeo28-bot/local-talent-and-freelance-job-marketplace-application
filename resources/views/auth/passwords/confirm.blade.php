@extends('layouts.app')

@section('content')
<div class="container flex justify-center px-4 py-8 mx-auto">
    <div class="w-full max-w-sm sm:max-w-full lg:max-w-lg">
        <div class="">
            <div class="card  p-4 flex items-center flex-col">
                <img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 mb-4">
                <div class="titles font-bold text-2xl text-white mb-10 max-sm:text-xl">{{ __('Confirm Password') }}</div>

                <div class="">
                    <h1 class="p_font max-sm:text-sm text-white">{{ __('Please confirm your password before continuing.') }}</h1>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3 mt-3">
                            <label for="password" class="max-sm:text-sm text-white">{{ __('Password') }}</label>

                            <div class="mt-2">
                                <input id="password" type="password" class="max-sm:text-sm poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="sign_in cursor-pointer flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-lg font-semibold text-white hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 mb-4 max-[640px]:text-sm/6">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="forgot_pass btn btn-link text-blue-400   hover:text-blue-300 max-[640px]:text-sm" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
