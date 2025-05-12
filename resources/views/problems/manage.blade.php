@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">Manage Problem: {{ $problem->title }}</h2>

    <form method="POST" action="{{ route('problems.assign', $problem->id) }}">
        @csrf

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="w-full border p-2">
                <option value="pending" {{ $problem->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ $problem->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="resolved" {{ $problem->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Status</button>
    </form>
</div>
@endsection
