@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow-lg mt-10 mb-12">
    <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        🚨 Report a New Problem
    </h2>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-lg mb-6 text-sm shadow-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="leading-tight">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('problems.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Title --}}
        <div>
            <label for="title" class="block mb-2 text-sm font-semibold text-gray-700">
                Title <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" id="title" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="e.g., Broken streetlight in Sector 9">
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block mb-2 text-sm font-semibold text-gray-700">
                Description <span class="text-red-500">*</span>
            </label>
            <textarea name="description" id="description" rows="5" required
                      class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="Explain the issue clearly..."></textarea>
        </div>

        {{-- Category --}}
        <div>
            <label for="category" class="block mb-2 text-sm font-semibold text-gray-700">
                Category <span class="text-red-500">*</span>
            </label>
            <select name="category" id="category" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select a category</option>
                <option value="infrastructure">Infrastructure</option>
                <option value="environment">Environment</option>
                <option value="safety">Safety</option>
                <option value="public services">Public Services</option>
            </select>
        </div>

        {{-- Location --}}
        <div>
            <label for="location" class="block mb-2 text-sm font-semibold text-gray-700">
                Location <span class="text-gray-400 font-normal">(Optional)</span>
            </label>
            <input type="text" name="location" id="location"
                   class="w-full border border-gray-300 rounded-lg px-4 py-3 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="e.g., Street name, city">
        </div>

        {{-- Media Upload --}}
        <div>
            <label for="media" class="block mb-2 text-sm font-semibold text-gray-700">
                Upload Media <span class="text-gray-400 font-normal">(Image or video)</span>
            </label>
            <input type="file" name="media" id="media"
                   class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                          file:rounded-md file:border-0 file:bg-blue-600 file:text-white
                          hover:file:bg-blue-700 transition cursor-pointer" />
        </div>

        {{-- Submit --}}
        <div class="text-right">
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition duration-200">
                📤 Submit Problem
            </button>
        </div>
    </form>
</div>
@endsection
