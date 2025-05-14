@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between flex-wrap gap-4">
    <div>
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Problem Management') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Welcome back, {{ auth()->user()->name }}! Below is the list of reported problems with assignment and status controls.
        </p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-red-600 hover:underline font-medium">⎋ Logout</button>
    </form>
</div>
@endsection

@section('content')
<div class="py-8 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-200 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @forelse($problems as $problem)
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $problem->title }}</h3>
                        <p class="text-sm text-gray-600 mb-1">Reported by: <strong>{{ $problem->user->name }}</strong></p>
                        <p class="text-sm text-gray-600">
                            Status: 
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium 
                                {{ $problem->status === 'resolved' ? 'bg-green-100 text-green-700' : 
                                   ($problem->status === 'in_progress' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst(str_replace('_', ' ', $problem->status)) }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-600 mt-1">
                            Assigned to: 
                            <strong>{{ $problem->assigned_to ?? '— Unassigned' }}</strong>
                        </p>
                    </div>
                </div>

                <!-- Assign Authority -->
                <div class="mt-4 flex flex-col sm:flex-row sm:items-center gap-3">
                    <form method="POST" action="{{ route('admin.problems.assign', $problem->id) }}" class="flex gap-2">
                        @csrf
                        <select name="assigned_to" class="border border-gray-300 rounded px-2 py-1 text-sm shadow-sm">
                            <option value="">Select Authority</option>
                            @foreach($authorities as $auth)
                                <option value="{{ $auth->name }}" {{ $problem->assigned_to === $auth->name ? 'selected' : '' }}>
                                    {{ $auth->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="text-sm text-blue-600 hover:underline font-medium">
                            ✅ Assign
                        </button>
                    </form>

                    <!-- Update Status -->
                    <form method="POST" action="{{ route('admin.problems.status', $problem->id) }}" class="flex gap-2">
                        @csrf
                        <select name="status" class="border border-gray-300 rounded px-2 py-1 text-sm shadow-sm">
                            @foreach(['pending', 'in_progress', 'resolved'] as $status)
                                <option value="{{ $status }}" {{ $problem->status === $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="text-sm text-green-600 hover:underline font-medium">
                            🔄 Update Status
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center text-gray-500 py-16 text-sm">
                😕 No problems have been reported yet.
            </div>
        @endforelse
    </div>
</div>
@endsection
