@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between mb-6 flex-wrap gap-4">
    <h2 class="text-3xl font-bold text-gray-800 leading-tight">
        📝 Reported Problems
    </h2>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded shadow transition">
            ⎋ Logout
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-5 py-4 rounded-lg mb-6 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-2 items-center">
            <input type="text" name="search" placeholder="Search problems..." value="{{ request('search') }}"
                class="border border-gray-300 rounded px-3 py-2 text-sm w-60">

            <select name="category" class="border border-gray-300 rounded px-2 py-2 text-sm">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                        {{ ucfirst($category) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="text-sm bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Filter
            </button>

            @if(request()->has('search') || request()->has('category'))
                <a href="{{ route('problems.index') }}" class="text-sm text-gray-600 hover:underline ml-2">Reset</a>
            @endif
        </form>

        <a href="{{ route('problems.create') }}"
           class="bg-green-600 text-white text-sm px-4 py-2 rounded shadow hover:bg-green-700 transition">
            📝 Report New Problem
        </a>
    </div>

    @if($problems->count())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($problems as $problem)
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition border border-gray-200 flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">
                        {{ $problem->title }}
                        @if($problem->votes()->where('type', 'up')->count() > 10)
                            <span class="ml-2 px-2 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full">🔥 Trending</span>
                        @endif
                    </h3>

                    <p class="text-gray-700 text-sm mb-4">{{ $problem->description }}</p>

                    <div class="text-sm text-gray-600 flex flex-wrap gap-x-6 gap-y-2 mb-4">
                        <div><strong>📂 Category:</strong> {{ ucfirst($problem->category) }}</div>
                        <div><strong>📌 Status:</strong>
                            <span class="inline-block bg-gray-100 px-2 py-0.5 rounded text-gray-800">
                                {{ ucfirst(str_replace('_', ' ', $problem->status)) }}
                            </span>
                        </div>
                        @if ($problem->assigned_to)
                            <div><strong>👤 Assigned to:</strong> 
                                <span class="text-blue-600 font-medium">{{ $problem->assigned_to }}</span>
                            </div>
                        @endif
                    </div>

                    @if ($problem->media_path)
                        <div class="mt-4">
                            @php $media = Storage::url($problem->media_path); @endphp
                            @if(Str::endsWith($problem->media_path, ['jpg', 'jpeg', 'png']))
                                <img src="{{ $media }}"
                                     onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'"
                                     alt="Problem Media"
                                     class="w-full max-w-full h-auto rounded-lg border shadow-sm object-cover">
                            @elseif(Str::endsWith($problem->media_path, ['mp4']))
                                <video controls class="w-full max-w-full rounded-lg mt-2 border shadow-sm">
                                    <source src="{{ $media }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-4">
                        <form method="POST" action="{{ route('problems.vote', $problem->id) }}">
                            @csrf
                            <input type="hidden" name="type" value="up">
                            <button type="submit" class="flex items-center text-sm text-green-600 hover:text-green-700 font-medium">
                                👍 Upvote
                            </button>
                        </form>

                        <form method="POST" action="{{ route('problems.vote', $problem->id) }}">
                            @csrf
                            <input type="hidden" name="type" value="down">
                            <button type="submit" class="flex items-center text-sm text-red-600 hover:text-red-700 font-medium">
                                👎 Downvote
                            </button>
                        </form>
                    </div>

                    <div class="text-sm text-gray-600">
                        👍 <strong>{{ $problem->votes()->where('type', 'up')->count() }}</strong> |
                        👎 <strong>{{ $problem->votes()->where('type', 'down')->count() }}</strong>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('problems.show', $problem->id) }}"
                       class="inline-block text-sm font-medium text-indigo-600 hover:underline">
                        View Details & Discuss →
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    @else
        <div class="text-center py-20 text-gray-400">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" class="w-24 mx-auto mb-4 opacity-60" alt="No problems">
            <p class="text-lg font-semibold">No problems found.</p>
            <p class="text-sm mt-1">Try different filters or <a href="{{ route('problems.create') }}" class="text-blue-500 underline">report a new one</a>.</p>
        </div>
    @endif

    <div class="mt-10">
        {{ $problems->links('pagination::tailwind') }}
    </div>
</div>
@endsection
