@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Welcome back, {{ auth()->user()->name }}! Here’s a quick overview of problems reported.
            </p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-blue-600 hover:underline bg-transparent border-0 p-0 m-0">
                Logout
            </button>
        </form>
    </div>
@endsection

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto bg-white p-6 rounded shadow space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @forelse($problems as $problem)
            <div class="border-b pb-4">
                <h3 class="font-semibold text-lg text-gray-800">{{ $problem->title }}</h3>
                <p class="text-sm text-gray-600">Reported by: {{ $problem->user->name }}</p>
                <p class="text-sm text-gray-700">Status: <strong>{{ ucfirst($problem->status) }}</strong></p>
                <p class="text-sm text-gray-700">Assigned to: <strong>{{ $problem->assigned_to ?? 'Unassigned' }}</strong></p>

                <!-- Assign Authority -->
                <form method="POST" action="{{ route('admin.problems.assign', $problem->id) }}" class="mt-2 flex items-center space-x-2">
                    @csrf
                    <select name="assigned_to" class="border border-gray-300 p-1 rounded text-sm">
                        @foreach($authorities as $auth)
                            <option value="{{ $auth->name }}" {{ $problem->assigned_to === $auth->name ? 'selected' : '' }}>
                                {{ $auth->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="text-blue-600 hover:underline text-sm">Assign</button>
                </form>

                <!-- Update Status -->
                <form method="POST" action="{{ route('admin.problems.status', $problem->id) }}" class="mt-1 flex items-center space-x-2">
                    @csrf
                    <select name="status" class="border border-gray-300 p-1 rounded text-sm">
                        @foreach(['pending', 'in_progress', 'resolved'] as $status)
                            <option value="{{ $status }}" {{ $problem->status === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="text-green-600 hover:underline text-sm">Update Status</button>
                </form>
            </div>
        @empty
            <p class="text-gray-600 text-sm">No problems reported yet.</p>
        @endforelse
    </div>
</div>
@endsection
