@extends('layouts.app')

@section('content')
<div class="container flex justify-center px-4 py-8 mx-auto">
    <div class="w-full max-w-sm sm:max-w-full lg:max-w-lg">
        <div class="">
            <div class="card p-4 flex items-center flex-col">
                <img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 mb-4">
                <div class="titles font-bold text-2xl text-white mb-10 max-sm:text-xl">{{ __('Create an account') }}</div>

                <div class="card-body w-full">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-5">
                            <label for="name" class="text-white max-sm:text-sm">{{ __('Name') }}</label>

                            <div class="mt-2">
                                <input id="name" type="text" class="poppins-regular-italic p-2 w-full text-white border-2 rounded-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label for="email" class="text-white max-sm:text-sm"> {{ __('Email Address') }}</label>

                            <div class="mt-2">
                                <input id="email" type="email" class="poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-5">
                            <label for="password" class="text-white max-sm:text-sm">{{ __('Password') }}</label>

                            <div class="mt-2">
                                <input id="password" type="password" class="poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-8">
                            <label for="password-confirm" class="text-white max-sm:text-sm">{{ __('Confirm Password') }}</label>

                            <div class="mt-2">
                                <input id="password-confirm" type="password" class="poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="row mb-5">
                            <label for="user_type" class="text-white max-sm:text-sm">{{ __('Register as') }}</label>

                            <div class="mt-2">
                                <select id="user_type" name="user_type" required 
                                    class="poppins-regular-italic p-2 w-full text-white border-2 rounded-lg bg-gray-800">
                                    <option value="">-- Select User Type --</option>
                                    <option value="employee" {{ old('user_type') == 'employee' ? 'selected' : '' }}>Employee</option>
                                    <option value="client" {{ old('user_type') == 'client' ? 'selected' : '' }}>Client</option>
                                </select>

                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="mb-10">
                                <button type="submit" class="cursor-pointer flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-lg font-semibold text-white hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 mb-4 max-[640px]:text-sm/6">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="flex items-center gap-2">
                                    <p class="p_fonts text-white max-[640px]:text-sm">Already have an account?  </p>
                                    <a href="#" class="p_fonts text-blue-400 hover:text-blue-300 max-[640px]:text-sm">Log in here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
