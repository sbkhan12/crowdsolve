@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between animate-fade-in">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight tracking-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            👋 Welcome back, <span class="font-semibold text-blue-600">{{ auth()->user()->name }}</span>!
        </p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-white bg-gradient-to-r from-red-500 to-pink-500 hover:opacity-90 px-4 py-2 rounded-lg shadow-md transition duration-150">
            ⎋ Logout
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen animate-fade-in">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Animated Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <x-dashboard.card icon=\"🧾\" title=\"Total Problems\" value=\"{{ \App\Models\Problem::count() }}\" color=\"blue\" />
            <x-dashboard.card icon=\"👍\" title=\"Your Upvotes\" value=\"{{ \App\Models\Vote::where('user_id', auth()->id())->where('type', 'up')->count() }}\" color=\"green\" />
            @if(auth()->user()->role === 'authority')
                <x-dashboard.card icon=\"📌\" title=\"Assigned to You\" value=\"{{ \App\Models\Problem::where('assigned_to', auth()->user()->name)->count() }}\" color=\"yellow\" />
            @endif
        </div>

        <!-- Panels -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Welcome Panel -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-blue-400 hover:shadow-2xl transition">
                <h3 class="text-lg font-bold text-blue-600 mb-2">🎉 Welcome to CrowdSolve!</h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    This platform empowers <strong>citizens</strong>, <strong>experts</strong>, and <strong>authorities</strong> to collaboratively identify and solve public issues. Use your tools, make an impact!
                </p>
            </div>
<div class="bg-white p-4 rounded shadow text-sm">
    🏅 <strong>Reward Points:</strong> {{ auth()->user()->reward_points }}
</div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-indigo-400 hover:shadow-2xl transition">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🚀 Quick Actions</h3>
                <ul class="text-sm text-indigo-700 space-y-3 font-medium list-disc list-inside">
                    <li><a href="{{ route('problems.index') }}" class="hover:underline">📋 View All Problems</a></li>
                    <li><a href="{{ route('problems.create') }}" class="hover:underline">📝 Report a New Problem</a></li>
                    @if(auth()->user()->role === 'authority')
                        <li><a href="#" class="hover:underline">🛠 Manage Assigned Problems</a></li>
                    @endif
                    @if(auth()->user()->role === 'expert')
                        <li><a href="#" class="hover:underline">🌟 Contribute Expert Advice</a></li>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">🧭 Admin Panel</a></li>
                    @endif
                </ul>
            </div>

            <!-- Role Info -->
            <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-gray-400 hover:shadow-2xl transition">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">🔑 Your Role</h3>
                <p class="text-sm text-gray-800">
                    You are logged in as: 
                    <span class="inline-block bg-gray-100 text-gray-900 font-bold px-2 py-1 rounded capitalize shadow-sm">
                        {{ auth()->user()->role }}
                    </span>
                </p>
                <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                    Your role provides access to role-specific tools. Explore your dashboard and contribute to local solutions!
                </p>
            </div>

        </div>

        <!-- Placeholder for future chart section -->
        <div class="bg-white p-6 rounded-xl shadow-lg mt-8 border-t-4 border-purple-400">
            <h3 class="text-lg font-bold text-purple-600 mb-4">📊 Coming Soon: Community Analytics</h3>
            <p class="text-sm text-gray-700">We’re working on visual dashboards that will show problem trends, resolution rates, and top contributors. Stay tuned!</p>
        </div>

    </div>
</div>
@endsection
