@extends('layouts.app')

@section('header')
<h2 class="text-2xl font-bold text-gray-800">📊 Analytics Dashboard</h2>
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 space-y-10">

    <div class="bg-white rounded-xl p-6 shadow">
        <h3 class="text-lg font-semibold mb-3 text-indigo-600">📈 Problem Trends</h3>
        <canvas id="problemTrendChart" height="100"></canvas>
    </div>

    <div class="bg-white rounded-xl p-6 shadow">
        <h3 class="text-lg font-semibold mb-3 text-green-600">🏅 Top Upvoted Users</h3>
        <ul class="text-sm space-y-2">
            @foreach ($topUsers as $user)
                <li class="flex justify-between items-center">
                    <span>{{ $user->name }} ({{ $user->votes_count }} votes)</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('problemTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($problemTrend->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))) !!},
            datasets: [{
                label: 'Problems Reported',
                data: {!! json_encode($problemTrend->pluck('total')) !!},
                backgroundColor: 'rgba(99, 102, 241, 0.7)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
