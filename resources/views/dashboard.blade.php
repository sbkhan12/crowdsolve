@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-bold text-3xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Hello {{ auth()->user()->name }}, here’s a quick summary of your activity and tools to get started.
            </p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-semibold">
                ⎋ Logout
            </button>
        </form>
    </div>
@endsection

@section('content')
<div class="py-10 bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300">
                <h3 class="text-sm font-medium text-gray-500">Total Reported Problems</h3>
                <p class="text-3xl font-extrabold text-blue-600 mt-2">
                    {{ \App\Models\Problem::count() }}
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300">
                <h3 class="text-sm font-medium text-gray-500">Your Upvotes</h3>
                <p class="text-3xl font-extrabold text-green-600 mt-2">
                    {{ \App\Models\Vote::where('user_id', auth()->id())->where('type', 'up')->count() }}
                </p>
            </div>

            @if(auth()->user()->role === 'authority')
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition duration-300">
                <h3 class="text-sm font-medium text-gray-500">Assigned to You</h3>
                <p class="text-3xl font-extrabold text-yellow-500 mt-2">
                    {{ \App\Models\Problem::where('assigned_to', auth()->user()->name)->count() }}
                </p>
            </div>
            @endif
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- Welcome Message -->
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h3 class="text-xl font-bold text-blue-600 mb-3">🎉 Welcome to CrowdSolve!</h3>
                <p class="text-gray-700 text-sm leading-relaxed">
                    This platform empowers users to report and resolve community issues collaboratively.
                    Browse reported problems, contribute your insights, or take action based on your role.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">🚀 Quick Actions</h3>
                <ul class="text-sm text-blue-700 space-y-3 font-medium">
                    <li>
                        <a href="{{ route('problems.index') }}" class="hover:underline">
                            📋 View All Problems
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('problems.create') }}" class="hover:underline">
                            📝 Report a New Problem
                        </a>
                    </li>
                    @if(auth()->user()->role === 'authority')
                        <li>
                            <a href="#" class="hover:underline">
                                🛠 Manage Assigned Problems
                            </a>
                        </li>
                    @endif
                    @if(auth()->user()->role === 'expert')
                        <li>
                            <a href="#" class="hover:underline">
                                🌟 Contribute Expert Advice
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- User Role Info -->
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">🔑 Your Role</h3>
                <p class="text-gray-800 text-sm">
                    Logged in as: <span class="font-bold">{{ ucfirst(auth()->user()->role) }}</span>
                </p>
                <p class="text-gray-600 text-sm mt-2">
                    Your role determines your ability to report, vote, moderate, or manage issues. Make an impact today.
                </p>
            </div>

        </div>
    </div>
</div>
@endsection
