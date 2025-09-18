@extends('layouts.app')

@section('body-class', 'bg-[#F0F0F0]')

@section('content')
    @include('components.nav_client')


    <!-- main content -->
    <section class="w-full flex min-h-[80vh] flex-col items-center  px-20 max-lg:px-10 max-sm:px-5 pt-10 max-lg:pt-5">
        <div class="xl:w-6xl  mx-auto px-5 max-sm:px-2 mb-10 w-full max-lg:px-0 ">
            <h1 class="sub_title sm:text-xl">Applicants</h1>
            <p class="home_p_font mb-5 text-sm">Manage and review freelancers who applied to your job postings.</p>

            
            {{-- no applicants yet --}}
            @if ($applications->isEmpty())
            <div class="w-full h-[300px] flex flex-col justify-center items-center border-2 border-dashed border-gray-400 rounded-lg mt-10 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-15 mb-2 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <p class="p_font text-gray-500 text-center p-5">No applicants yet. Check back later!</p>
            </div>
            @else

            {{-- table div --}}
            <div id="table_div" class="overflow-x-auto shadow-lg rounded-lg ">
            <table class="w-full min-w-[700px] shadow-lg rounded-lg overflow-hidden">
                <thead class="bg-gray-200 ">
                    <tr class="bg-gray-300">
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">User Name</th>
                         <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Full Name</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Job Title</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Application Date</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Status</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Actions</th>
                        <th class="px-4 py-2 text-left sub_title_font font-semibold! uppercase text-sm">Drop</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                    <tr class="border-b-2 border-gray-300 py-2 hover:bg-gray-200">
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <a href="#" class="underline text-blue-700 hover:text-blue-400">
                                {{ $application->user ? $application->user->name : $application->full_name }}
                            </a>

                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm capitalize">    
                                {{ $application->full_name }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{ $application->job->job_title ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            {{ $application->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-4 py-2 p_font text-sm 
                            {{ $application->status == 'pending' ? 'text-orange-600' : ($application->status == 'accepted' ? 'text-green-600' : 'text-red-600') }}">
                              <span class="p-2 bg-amber-50 rounded-lg {{ $application->status == 'pending' ? 'border-1 border-amber-600 bg-orange-200' : ($application->status == 'accepted' ? 'border-1 border-green-600 bg-green-200' : 'border-1 border-red-600 bg-red-200') }}">{{ ucfirst($application->status) }}</span>
                        </td>

                        <td class="px-4 py-2 p_font max-lg:text-sm max-lg:w-[50px] ">
                           <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="bg-[#1e2939] px-3 py-2 rounded mr-2 button_font text-sm text-green-400 cursor-pointer hover:opacity-80 max-[1078px]:w-full max-[1078px]:mb-1">Accept</button>
                            </form>

                            <form action="{{ route('applications.updateStatus', $application->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-[#1e2939] px-3 py-2 rounded button_font text-sm text-red-400 cursor-pointer hover:opacity-80 max-[1078px]:w-full">Reject</button>
                            </form>
                        </td>
                        <td class="px-4 py-2 p_font max-lg:text-sm">
                            <form action="{{ route('applications.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this application?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#1e2939] p-2 rounded-lg cursor-pointer hover:opacity-70">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" 
                                        stroke-width="1.5" stroke="currentColor" class="size-5 text-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21
                                            c.342.052.682.107 1.022.166m-1.022-.165L18.16 
                                            19.673a2.25 2.25 0 0 1-2.244 2.077H8.084
                                            a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79
                                            m14.456 0a48.108 48.108 0 0 0-3.478-.397
                                            m-12 .562c.34-.059.68-.114 1.022-.165
                                            m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 
                                            0v-.916c0-1.18-.91-2.164-2.09-2.201
                                            a51.964 51.964 0 0 0-3.32 0c-1.18.037
                                            -2.09 1.022-2.09 2.201v.916m7.5 
                                            0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach
                    <!-- More rows as needed -->
                </tbody>
            </table>
            </div>
            @endif

            

        </div>
    </section>



    @include('components.footer_client')

    
    <script src="{{ asset('js/client.js') }}"></script>
@endsection