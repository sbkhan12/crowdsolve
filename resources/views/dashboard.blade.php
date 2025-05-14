@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h2 class="text-3xl font-extrabold text-gray-900 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            👋 Hello <span class="font-semibold">{{ auth()->user()->name }}</span>, here's a snapshot of your activity.
        </p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="text-sm text-white bg-red-500 hover:bg-red-600 px-4 py-2 rounded-md shadow">
            ⎋ Logout
        </button>
    </form>
</div>
@endsection

@section('content')
<div class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
                <h3 class="text-sm font-medium text-gray-500">Total Reported Problems</h3>
                <p class="text-4xl font-extrabold text-blue-600 mt-2">{{ \App\Models\Problem::count() }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
                <h3 class="text-sm font-medium text-gray-500">Your Upvotes</h3>
                <p class="text-4xl font-extrabold text-green-600 mt-2">
                    {{ \App\Models\Vote::where('user_id', auth()->id())->where('type', 'up')->count() }}
                </p>
            </div>

            @if(auth()->user()->role === 'authority')
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500">
                <h3 class="text-sm font-medium text-gray-500">Assigned to You</h3>
                <p class="text-4xl font-extrabold text-yellow-500 mt-2">
                    {{ \App\Models\Problem::where('assigned_to', auth()->user()->name)->count() }}
                </p>
            </div>
            @endif
        </div>

        <!-- Main Panels -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Welcome -->
            <div class="bg-white p-6 rounded-2xl shadow-md border-t-4 border-blue-400">
                <h3 class="text-lg font-bold text-blue-600 mb-3">🎉 Welcome to CrowdSolve!</h3>
                <p class="text-gray-700 text-sm">
                    This platform empowers citizens, experts, and authorities to collaboratively report and resolve public issues. Take action based on your role!
                </p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-2xl shadow-md border-t-4 border-indigo-400">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🚀 Quick Actions</h3>
                <ul class="text-sm text-indigo-700 space-y-3 font-medium">
                    <li>
                        <a href="{{ route('problems.index') }}" class="hover:underline">📋 View All Problems</a>
                    </li>
                    <li>
                        <a href="{{ route('problems.create') }}" class="hover:underline">📝 Report a New Problem</a>
                    </li>
                    @if(auth()->user()->role === 'authority')
                        <li>
                            <a href="#" class="hover:underline">🛠 Manage Assigned Problems</a>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'expert')
                        <li>
                            <a href="#" class="hover:underline">🌟 Contribute Expert Advice</a>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="hover:underline">🧭 Admin Panel</a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- Role Info -->
            <div class="bg-white p-6 rounded-2xl shadow-md border-t-4 border-gray-400">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">🔑 Your Role</h3>
                <p class="text-sm text-gray-800">
                    You are logged in as: 
                    <span class="inline-block bg-gray-200 text-gray-800 font-bold px-2 py-1 rounded ml-1 capitalize">
                        {{ auth()->user()->role }}
                    </span>
                </p>
                <p class="text-sm text-gray-600 mt-2">
                    Your role gives you access to specific tools and privileges. Make the most of your contribution!
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
