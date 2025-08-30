@extends('layouts.app')

@section('content')
<div class="container flex flex-col items-center px-6 py-8 mx-auto lg:py-0">
    <div class="w-full max-w-sm sm:max-w-full lg:max-w-lg">
        <div class="">
            <div class="card  p-4 flex items-center flex-col">
                {{-- <h1 class="font-bold text-4xl mb-10">FREELANCO</h1> --}}
                 <a href="{{url('/')}}"><img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 mb-4">
                    </a>
                <div class="titles font-bold text-2xl text-white mb-10 max-sm:text-xl">{{ __('Reset Password') }}</div>

                <div class=" w-full">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-6">
                            <label for="email" class="max-sm:text-sm text-white">{{ __('Email Address') }}</label>

                            <div class="col-md-6 mt-2">
                                <input id="email" type="email" class="max-sm:text-sm p-2 w-full text-white border-2 rounded-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="">
                                <button type="submit" class="sign_in cursor-pointer flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-lg font-semibold text-white hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 mb-6 max-[640px]:text-sm/6">
                                    {{ __('Send Password Reset Link') }}

                                </button>
                            </div>

                            <div class="flex items-center gap-2">
                                    <p class="p_fonts text-white max-[640px]:text-sm">Don't have an account yet? </p>
                                    <a href="{{ route('register') }}" class="p_fonts text-blue-400 hover:text-blue-300 max-[640px]:text-sm">Sign up now.</a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
