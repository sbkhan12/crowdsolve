@extends('layouts.app')

@section('header')
<h2 class="text-2xl font-bold text-gray-800">🧾 Reports Overview</h2>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    @forelse ($problems as $problem)
        <div class="bg-white p-4 mb-4 rounded shadow">
            <h3 class="font-semibold text-lg text-red-600">{{ $problem->title }}</h3>
            <p class="text-gray-600 text-sm mb-2">{{ $problem->description }}</p>
            <div class="text-sm text-gray-500">
                📂 Category: {{ ucfirst($problem->category) }} |
                📌 Status: <span class="capitalize">{{ $problem->status }}</span> |
                👤 Reporter: {{ $problem->user->name }}
            </div>
            <a href="{{ route('problems.show', $problem->id) }}" class="text-sm text-indigo-600 hover:underline mt-2 inline-block">View Full Problem →</a>
        </div>
    @empty
        <p class="text-gray-500 text-center">No unresolved reports at the moment.</p>
    @endforelse
</div>
@endsection
