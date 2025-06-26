@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">🛡️ Admin Dashboard</h2>
        <p class="mt-2 text-sm text-gray-600">
            👋 Welcome back, <span class="font-semibold">{{ auth()->user()->name }}</span>! Here’s the latest insights.
        </p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
            ⎋ Logout
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="py-10 bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $cards = [
                    ['title' => 'Total Users', 'count' => $totalUsers, 'color' => 'blue', 'icon' => '👥'],
                    ['title' => 'Total Problems', 'count' => $totalProblems, 'color' => 'red', 'icon' => '📌'],
                    ['title' => 'Total Votes', 'count' => $totalVotes, 'color' => 'green', 'icon' => '👍'],
                    ['title' => 'Total Comments', 'count' => $totalComments, 'color' => 'yellow', 'icon' => '💬'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="bg-white p-6 rounded-xl shadow border-l-4 border-{{ $card['color'] }}-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm text-gray-500">{{ $card['title'] }}</h3>
                        <p class="text-3xl font-bold text-{{ $card['color'] }}-600 mt-1">{{ $card['count'] }}</p>
                    </div>
                    <div class="text-3xl">{{ $card['icon'] }}</div>
                </div>
            @endforeach
        </div>

        <!-- Admin Tools -->
        <div class="bg-white p-6 rounded-xl shadow border-t-4 border-indigo-500">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🛠️ Admin Tools</h3>
            <ul class="text-sm text-indigo-700 space-y-2 list-disc list-inside">
                <li><a href="{{ route('admin.users') }}" class="hover:underline">👥 Manage Users</a></li>
                <li><a href="{{ route('admin.problems') }}" class="hover:underline">📌 Moderate Problems</a></li>
                <li><a href="{{ route('admin.reports') }}" class="hover:underline">🧾 Review Reports</a></li>
                <li><a href="{{ route('admin.analytics') }}" class="hover:underline">📊 View Site Analytics</a></li>
            </ul>
        </div>

        <!-- Top Contributors -->
        <div class="bg-white p-6 rounded-xl shadow border-t-4 border-green-500">
            <h3 class="text-lg font-semibold text-green-700 mb-4">🏅 Top Contributors</h3>
            <ul class="space-y-2 text-sm">
                @php
                    $topUsers = \App\Models\User::withCount([
                        'votes as upvotes_count' => function ($q) {
                            $q->where('type', 'up');
                        }
                    ])->orderByDesc('upvotes_count')->take(5)->get();
                @endphp

                @forelse ($topUsers as $user)
                    <li class="flex justify-between items-center">
                        <span>{{ $user->name }} ({{ $user->upvotes_count }} upvotes)</span>
                        <span class="text-xs px-2 py-1 rounded font-semibold text-green-800 bg-green-100">
                            @if ($user->upvotes_count >= 100)
                                🏆 Super Contributor
                            @elseif ($user->upvotes_count >= 50)
                                🎖️ Active Helper
                            @elseif ($user->upvotes_count >= 10)
                                💬 Community Member
                            @else
                                🌱 New Contributor
                            @endif
                        </span>
                    </li>
                @empty
                    <li class="text-gray-500">No contributors yet.</li>
                @endforelse
            </ul>
        </div>

        <!-- Analytics -->
        <div class="bg-white p-6 rounded-xl shadow border-t-4 border-purple-500">
            <h3 class="text-lg font-bold text-purple-600 mb-3">📈 Problem Trends (Last 6 Months)</h3>
            <canvas id="problemsChart" class="w-full h-64"></canvas>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('problemsChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($problemStats['months']) !!},
            datasets: [{
                label: 'Problems Reported',
                data: {!! json_encode($problemStats['counts']) !!},
                borderColor: 'rgba(99, 102, 241, 1)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush
