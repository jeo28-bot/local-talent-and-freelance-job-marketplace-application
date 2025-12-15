@foreach($ratings as $rating)
<div class="bg-white rounded-lg shadow-md p-4 p_font mb-4">

    <div class="flex">
        <img 
        src="{{ $rating->reviewer->profile_pic ? asset('storage/' . $rating->reviewer->profile_pic) : asset('assets/defaultUserPic.png') }}" 
        alt="{{ $rating->reviewer->name }}'s profile pic" 
        class="w-12 h-12 rounded-full max-sm:w-10 max-sm:h-10 border-2 border-gray-300">

        <div class="ml-4">
            <h2 class="text-lg font-semibold mb-2 max-sm:mb-0">{{ $rating->reviewer->name }}</h2>
            <div class="flex flex-col max-sm:text-sm!">
                <div class="flex items-center text-amber-500 mb-2">
                    {{-- Stars --}}
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $rating->rating)
                            {{-- solid star --}}
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 max-sm:size-5">
                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd"></path>
                            </svg>
                        @else
                            {{-- outline star --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 max-sm:size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"></path>
                            </svg>
                        @endif
                    @endfor

                    {{-- rating number --}}
                    <span class="text-gray-600 ml-2">{{ number_format($rating->rating, 1) }}</span>
                </div>
                
                {{-- date --}}
                <span class="text-gray-500 text-sm mb-2">{{ $rating->created_at->format('F d, Y') }}</span>

                {{-- message --}}
                <p>{{ $rating->message }}</p>
            </div>
        </div>
    </div>

</div>
@endforeach


{{-- no notification rn --}}
@if ($ratings->isEmpty())
<div class="flex flex-col items-center justify-center py-10 text-center bg-gray-200 rounded-xl px-10 ">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon" class="w-16 h-16 text-gray-400 mb-4">
    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"></path>
    </svg>

    <h2 class="text-xl font-semibold text-gray-800 sub_title_font">No reviews and ratings right now.</h2>
    <p class="text-gray-500 mt-1 home_p_font">Check back later or be the first one to rate!</p>
</div>
@endif