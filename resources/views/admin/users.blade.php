@extends('layouts.app')

@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">User Management</h2>
        <p class="text-sm text-gray-600">Manage roles, search users, and control access.</p>
    </div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="text-sm text-red-600 hover:underline">⎋ Logout</button>
    </form>
</div>
@endsection

@section('content')
<div class="py-8 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        @if (session('success'))
            <div class="p-4 bg-green-100 text-green-800 border rounded">{{ session('success') }}</div>
        @endif

        <!-- Search + Filter -->
        <form method="GET" class="flex flex-wrap gap-4 mb-4">
            <input name="search" type="text" value="{{ request('search') }}"
                   placeholder="Search by name"
                   class="border rounded px-3 py-1 text-sm flex-grow">
            <select name="role" class="border rounded px-2 py-1 text-sm">
                <option value="">All Roles</option>
                @foreach(['citizen', 'expert', 'authority', 'admin'] as $role)
                    <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-1 text-sm rounded hover:bg-blue-700">Filter</button>
        </form>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs text-gray-600 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Change Role</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $user->name }}</td>
                            <td class="px-6 py-3">{{ $user->email }}</td>
                            <td class="px-6 py-3 capitalize">
                                <span class="px-2 py-1 text-xs rounded-full font-semibold
                                    @if($user->role === 'admin') bg-red-100 text-red-700
                                    @elseif($user->role === 'authority') bg-yellow-100 text-yellow-700
                                    @elseif($user->role === 'expert') bg-blue-100 text-blue-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                <form method="POST" action="{{ route('admin.users.updateRole', $user->id) }}">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="border px-2 py-1 text-sm rounded">
                                        @foreach(['citizen', 'expert', 'authority', 'admin'] as $role)
                                            <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>
                                                {{ ucfirst($role) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-3">
                                @if($user->is_banned)
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded">Banned</span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Active</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                <form method="POST" action="{{ route('admin.users.toggleBan', $user->id) }}">
                                    @csrf
                                    <button type="submit" class="text-xs text-white px-3 py-1 rounded 
                                        {{ $user->is_banned ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}">
                                        {{ $user->is_banned ? 'Unban' : 'Ban' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
