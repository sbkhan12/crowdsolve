@extends('layouts.app')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Welcome back, {{ auth()->user()->name }}! Here's a snapshot of platform activity.
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
<div class="py-10 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-gray-500">Total Users</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $totalUsers }}</p>
                </div>
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a4 4 0 00-4-4h-1m-6 6v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h5m6 0h6"/>
                </svg>
            </div>
            <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-gray-500">Total Problems</h3>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $totalProblems }}</p>
                </div>
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M18.364 5.636l-1.414-1.414L12 9.172 7.05 4.222 5.636 5.636 10.586 10.586 5.636 15.536l1.414 1.414L12 12.828l4.95 4.95 1.414-1.414L13.414 10.586z"/>
                </svg>
            </div>
            <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-gray-500">Total Votes</h3>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $totalVotes }}</p>
                </div>
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M14 9l-2 2-2-2m0 6l2-2 2 2M12 20c4.418 0 8-3.582 8-8s-3.582-8-8-8S4 7.582 4 12s3.582 8 8 8z"/>
                </svg>
            </div>
            <div class="bg-white p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h3 class="text-sm text-gray-500">Total Comments</h3>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $totalComments }}</p>
                </div>
                <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M7 8h10M7 12h4m1 8h2a2 2 0 002-2v-2.586a1 1 0 01.293-.707l3.707-3.707a1 1 0 000-1.414l-7-7a1 1 0 00-1.414 0l-7 7a1 1 0 000 1.414l3.707 3.707a1 1 0 01.293.707V18a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

        <!-- Management Tools -->
        @if(auth()->user()->role === 'admin')
        <div class="bg-white p-6 rounded-lg shadow mt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">🔧 Management Tools</h3>
            <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                <li><a href="/admin/users" class="text-blue-600 hover:underline">Manage Users</a></li>
                <li><a href="/admin/problems" class="text-blue-600 hover:underline">Moderate Problems</a></li>
                <li><a href="/admin/reports" class="text-blue-600 hover:underline">Review Reports</a></li>
                <li><a href="/admin/analytics" class="text-blue-600 hover:underline">View Site Analytics</a></li>
            </ul>
        </div>
        @endif

    </div>
</div>
@endsection
