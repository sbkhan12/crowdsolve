@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-extrabold text-gray-800 leading-tight">
            📝 Reported Problems
        </h2>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-semibold">
                ⎋ Logout
            </button>
    </div>
     
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Flash message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-lg mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Problem list --}}
    @forelse ($problems as $problem)
        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md mb-8 hover:shadow-lg transition-shadow duration-300">
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $problem->title }}</h3>
            <p class="text-gray-700 text-sm leading-relaxed mb-4">{{ $problem->description }}</p>

            {{-- Metadata --}}
            <div class="text-sm text-gray-600 flex flex-wrap gap-4 mb-4">
                <span><strong>📂 Category:</strong> {{ ucfirst($problem->category) }}</span>
                <span><strong>📌 Status:</strong> {{ str_replace('_', ' ', ucfirst($problem->status)) }}</span>
                @if ($problem->assigned_to)
                    <span><strong>👤 Assigned to:</strong> <span class="text-blue-600">{{ $problem->assigned_to }}</span></span>
                @endif
            </div>

            {{-- Media Preview --}}
            @if ($problem->media_path)
                <div class="mt-4">
                    @if(Str::endsWith($problem->media_path, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/' . $problem->media_path) }}" alt="Problem Media" class="w-full max-w-xs rounded-lg border">
                    @elseif(Str::endsWith($problem->media_path, ['mp4']))
                        <video controls class="w-full max-w-md mt-2 rounded-lg border">
                            <source src="{{ asset('storage/' . $problem->media_path) }}" type="video/mp4">
                        </video>
                    @endif
                </div>
            @endif

            {{-- Voting --}}
            <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-center gap-4">
                    <form method="POST" action="{{ route('problems.vote', $problem->id) }}">
                        @csrf
                        <input type="hidden" name="type" value="up">
                        <button type="submit" class="text-green-600 font-medium hover:underline flex items-center">
                            ▲ Upvote
                        </button>
                    </form>

                    <form method="POST" action="{{ route('problems.vote', $problem->id) }}">
                        @csrf
                        <input type="hidden" name="type" value="down">
                        <button type="submit" class="text-red-600 font-medium hover:underline flex items-center">
                            ▼ Downvote
                        </button>
                    </form>
                </div>
                <div class="text-sm text-gray-600">
                    👍 <strong>{{ $problem->votes()->where('type', 'up')->count() }}</strong> 
                    | 👎 <strong>{{ $problem->votes()->where('type', 'down')->count() }}</strong>
                </div>
            </div>

            {{-- View Details --}}
            <div class="mt-4">
                <a href="{{ route('problems.show', $problem->id) }}" class="inline-block text-blue-600 text-sm font-medium hover:underline">
                    View Details & Discuss →
                </a>
            </div>
        </div>
    @empty
        <div class="text-center text-gray-500 text-lg py-12">
            😕 No problems reported yet.
        </div>
    @endforelse

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $problems->links('pagination::tailwind') }}
    </div>
</div>
@endsection
