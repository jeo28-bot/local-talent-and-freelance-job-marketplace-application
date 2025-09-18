@extends('layouts.app')

@section('content')
<div class="container flex justify-center px-4 pb-20 mx-auto">
    <div class="w-full max-w-sm sm:max-w-full lg:max-w-lg">
        <div class="">
            <div class="card p-4 flex items-center flex-col">
                <a href="{{ url('/') }}"><img src="{{asset('assets/logoNoBg.png')}}" alt="logo" class="w-70 mb-4"></a>
                <div class="titles font-bold text-2xl text-white mb-5 max-sm:text-xl">{{ __('Create an account') }}</div>

                <div class="card-body w-full max-lg:w-lg max-sm:w-full">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3 max-sm:mb-2">
                            <label for="name" class="text-white max-sm:text-sm">{{ __('Name') }} <span class="text-red-400">*</span></label>

                            <div class="mt-2">
                                <input id="name" type="text" class="mb-2 poppins-regular-italic p-2 w-full text-white border-2 rounded-lg @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback text-red-400 p_font font-light" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 max-sm:mb-2">
                            <label for="email" class="text-white max-sm:text-sm"> {{ __('Email Address') }}<span class="text-red-400"> *</span></label>

                            <div class="mt-2">
                                <input id="email" type="email" class="mb-2 poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback text-red-400 p_font font-light mt-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 max-sm:mb-2">
                            <label for="phoneNum" class="text-white max-sm:text-sm p_font"> {{ __('Phone Number') }}<span class="text-red-400"> *</span></label>

                            <div class="mt-2">
                                <input id="phoneNum" type="phoneNum" class="mb-2 poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('phoneNum') is-invalid @enderror" name="phoneNum" value="{{ old('phoneNum') }}" required autocomplete="phoneNum">

                                @error('phoneNum')
                                    <span class="invalid-feedback text-red-400 p_font font-light mt-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="row mb-3 max-sm:mb-2">
                            <label for="password" class="text-white max-sm:text-sm">{{ __('Password') }}<span class="text-red-400"> *</span></label>

                            <div class="mt-2">
                                <input id="password" type="password" class="mb-2 poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback text-red-400 p_font font-light" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-5 max-sm:mb-2">
                            <label for="password-confirm" class="text-white max-sm:text-sm">{{ __('Confirm Password') }}<span class="text-red-400"> *</span></label>

                            <div class="mt-2">
                                <input id="password-confirm" type="password" class="poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3 max-sm:mb-2">
                            <label for="address" class="text-white max-sm:text-sm p_font"> {{ __('Complete Address') }}<span class="text-red-400"> *</span></label>

                            <div class="mt-2">
                                <input id="address" type="address" class="mb-2 poppins-regular-italic p-2 w-full text-white border-2 rounded-lg form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback text-red-400 p_font font-light mt-5" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-8">
                            <label for="user_type" class="text-white max-sm:text-sm">{{ __('Register as') }}<span class="text-red-400"> *</span></label>

                            <div class="mt-2">
                                <select id="user_type" name="user_type" required 
                                    class="sign_in poppins-regular-italic p-2 w-full text-white border-2 rounded-lg bg-gray-800">
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
                            <div class="mb-7">
                                <button type="submit" class="cursor-pointer flex w-full justify-center rounded-md bg-blue-500 px-3 py-2 text-lg font-semibold text-white hover:bg-blue-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-500 mb-4 max-[640px]:text-sm/6">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="flex items-center gap-2">
                                    <p class="p_fonts text-white max-[640px]:text-sm">Already have an account?  </p>
                                    <a href="{{ route('login') }}" class="p_fonts text-blue-400 hover:text-blue-300 max-[640px]:text-sm">Log in here</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
