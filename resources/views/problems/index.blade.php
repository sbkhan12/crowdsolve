@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between mb-6 flex-wrap gap-4">
    <h2 class="text-3xl font-bold text-gray-800 leading-tight ">
        📝 Reported Problems
    </h2>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded shadow">
            ⎋ Logout
        </button>
    </form>
</div>
@endsection

@section('content')
<!-- Filters & CTA -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Flash message --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-lg mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif
<!-- Filters & CTA -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

    <!-- Filter Form -->
    <form method="GET" class="flex flex-wrap gap-2 items-center">
        <input type="text" name="search" placeholder="Search problems..."
               value="{{ request('search') }}"
               class="border border-gray-300 rounded px-3 py-2 text-sm w-60"
        >
        <select name="category" class="border border-gray-300 rounded px-2 py-2 text-sm">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                    {{ ucfirst($category) }}
                </option>
            @endforeach
        </select>
        <button type="submit"
                class="text-sm bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Filter
        </button>
        @if(request()->has('search') || request()->has('category'))
            <a href="{{ route('problems.index') }}" class="text-sm text-gray-600 hover:underline ml-2">
                Reset
            </a>
        @endif
    </form>

    <!-- CTA Button -->
    <a href="{{ route('problems.create') }}"
       class="bg-green-600 text-white text-sm px-4 py-2 rounded shadow hover:bg-green-700 transition">
        📝 Report New Problem
    </a>
</div>

    {{-- Problem list --}}
    @forelse ($problems as $problem)
        <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition mb-6 border border-gray-200">
            <h3 class="text-2xl font-semibold text-gray-900 mb-2">{{ $problem->title }}</h3>
            <p class="text-gray-700 text-sm mb-4 leading-relaxed">{{ $problem->description }}</p>

            {{-- Metadata --}}
            <div class="text-sm text-gray-600 flex flex-wrap gap-x-6 gap-y-2 mb-4">
                <div><strong>📂 Category:</strong> {{ ucfirst($problem->category) }}</div>
                <div><strong>📌 Status:</strong>
                    <span class="inline-block bg-gray-100 px-2 py-0.5 rounded text-gray-800">
                        {{ ucfirst(str_replace('_', ' ', $problem->status)) }}
                    </span>
                </div>
                @if ($problem->assigned_to)
                    <div><strong>👤 Assigned to:</strong> 
                        <span class="text-blue-600">{{ $problem->assigned_to }}</span>
                    </div>
                @endif
            </div>

            {{-- Media Preview --}}
            @if ($problem->media_path)
                <div class="mt-4">
                    @if(Str::endsWith($problem->media_path, ['jpg', 'jpeg', 'png']))
                        <img src="{{ asset('storage/' . $problem->media_path) }}" alt="Problem Media" class="w-full max-w-sm rounded-lg border">
                    @elseif(Str::endsWith($problem->media_path, ['mp4']))
                        <video controls class="w-full max-w-md rounded-lg mt-2 border">
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
                        <button type="submit" class="flex items-center text-sm text-green-600 hover:text-green-700 font-medium">
                            ▲ Upvote
                        </button>
                    </form>

                    <form method="POST" action="{{ route('problems.vote', $problem->id) }}">
                        @csrf
                        <input type="hidden" name="type" value="down">
                        <button type="submit" class="flex items-center text-sm text-red-600 hover:text-red-700 font-medium">
                            ▼ Downvote
                        </button>
                    </form>
                </div>
                <div class="text-sm text-gray-600">
                    👍 <strong>{{ $problem->votes()->where('type', 'up')->count() }}</strong>
                    |
                    👎 <strong>{{ $problem->votes()->where('type', 'down')->count() }}</strong>
                </div>
            </div>

            {{-- View Details --}}
            <div class="mt-4">
                <a href="{{ route('problems.show', $problem->id) }}"
                   class="inline-block text-sm font-medium text-indigo-600 hover:underline">
                    View Details & Discuss →
                </a>
            </div>
        </div>
    @empty
        <div class="text-center text-gray-500 text-lg py-20">
            😕 No problems have been reported yet.
        </div>
    @endforelse

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $problems->links('pagination::tailwind') }}
    </div>
</div>
@endsection
