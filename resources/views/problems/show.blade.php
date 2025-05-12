@extends('layouts.app')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 leading-tight">
        Problem Details
        
    </h2>
    
    
    
@endsection

@section('content')
<div class="max-w-4xl mx-auto p-4 space-y-6">

    <!-- Problem Summary -->
    <div class="bg-white p-6 rounded shadow">
        <h3 class="text-2xl font-bold text-gray-900">{{ $problem->title }}</h3>
        <p class="mt-3 text-gray-800">{{ $problem->description }}</p>

        <div class="mt-4 text-sm text-gray-600">
            <p>Category: <strong>{{ ucfirst($problem->category) }}</strong></p>
            <p>Status: <span class="capitalize">{{ str_replace('_', ' ', $problem->status) }}</span></p>
            @if ($problem->assigned_to)
                <p>Assigned to: <span class="text-blue-600 font-medium">{{ $problem->assigned_to }}</span></p>
            @endif
        </div>

        @if ($problem->media_path)
            <div class="mt-4">
                @if(Str::endsWith($problem->media_path, ['jpg','jpeg','png']))
                    <img src="{{ asset('storage/' . $problem->media_path) }}" alt="Problem image" class="w-64 rounded">
                @elseif(Str::endsWith($problem->media_path, ['mp4']))
                    <video controls width="400" class="mt-2 rounded">
                        <source src="{{ asset('storage/' . $problem->media_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        @endif
    </div>

    <!-- Voting Info -->
    <div class="bg-white p-4 rounded shadow flex items-center justify-between">
        <div class="flex items-center gap-4">
            <form method="POST" action="{{ route('problems.vote', $problem->id) }}">
                @csrf
                <input type="hidden" name="type" value="up">
                <button class="text-green-600 font-semibold hover:underline">▲ Upvote</button>
            </form>

            <form method="POST" action="{{ route('problems.vote', $problem->id) }}">
                @csrf
                <input type="hidden" name="type" value="down">
                <button class="text-red-600 font-semibold hover:underline">▼ Downvote</button>
            </form>
        </div>

        <div class="text-sm text-gray-700">
            👍 {{ $problem->votes()->where('type', 'up')->count() }}
            |
            👎 {{ $problem->votes()->where('type', 'down')->count() }}
        </div>
    </div>

    <!-- Progress Updates -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="font-bold text-lg mb-3">📈 Progress Updates</h4>
        @forelse ($problem->updates as $update)
            <div class="border-l-4 border-blue-500 pl-4 mb-4">
                <p class="text-sm text-blue-800 font-medium">
                    {{ $update->user->name }} — {{ $update->created_at->format('M d, Y H:i') }}
                </p>
                <p class="text-gray-700">{{ $update->message }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500">No updates yet.</p>
        @endforelse

        @if (in_array(auth()->user()->role, ['authority', 'moderator']))
        <form method="POST" action="{{ route('progress.store', $problem->id) }}" class="mt-4">
            @csrf
            <textarea name="message" rows="3" class="w-full border p-2 rounded" placeholder="Add a progress update..."></textarea>
            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Post Update</button>
        </form>
        @endif
    </div>

    <!-- Comments Section -->
    <div class="bg-white p-4 rounded shadow">
        <h4 class="font-bold text-lg mb-3">💬 Discussion</h4>

        @forelse ($problem->comments as $comment)
            <div class="mb-6 border-l-2 border-gray-300 pl-4">
                <p class="font-semibold">
                    {{ $comment->user->name }}
                    @if ($comment->is_expert)
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded ml-2">🌟 Expert</span>
                    @endif
                </p>
                <p class="text-gray-700">{{ $comment->content }}</p>
                <small class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>

                <!-- Reply form -->
                <form method="POST" action="{{ route('comments.store', $problem->id) }}" class="mt-2">
                    @csrf
                    <textarea name="content" rows="2" class="w-full border p-2 text-sm rounded" placeholder="Reply..."></textarea>
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <button type="submit" class="text-sm text-blue-600 mt-1 hover:underline">Reply</button>
                </form>

                <!-- Replies -->
                @foreach ($comment->replies as $reply)
                    <div class="ml-4 mt-3 border-l-2 border-gray-200 pl-3">
                        <p class="font-medium">{{ $reply->user->name }} replied:</p>
                        <p class="text-gray-700">{{ $reply->content }}</p>
                        <small class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</small>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-sm text-gray-500">No comments yet.</p>
        @endforelse

        <!-- New comment form -->
        <form method="POST" action="{{ route('comments.store', $problem->id) }}">
            @csrf
            <textarea name="content" rows="3" class="w-full border p-2 mt-2 rounded" placeholder="Leave a comment..."></textarea>
            <button type="submit" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">Post Comment</button>
        </form>
    </div>
</div>
@endsection
