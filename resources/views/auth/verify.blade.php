@extends('layouts.app')

@section('content')
<div class="container flex justify-center px-4 py-8 mx-auto">
    <div class="w-full max-w-sm sm:max-w-full lg:max-w-lg">
        <div class="">
            <div class="card  p-4 flex items-center flex-col">
                <img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 mb-4">
                <div class="titles font-bold text-2xl text-white mb-10 max-sm:text-xl">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body text-white max-sm:text-sm">
                    @if (session('resent'))
                        <div class="alert alert-success " role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="mt-4 button_font cursor-pointer flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-lg font-semibold text-white hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 mb-4 max-[640px]:text-sm/6 btn btn-link p-0 m-0 align-baseline">{{ __('Click here to request another') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
