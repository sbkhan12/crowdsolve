<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Problem $problem)
    {
        $request->validate([
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'problem_id' => $problem->id,
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);
Comment::create([
    'user_id' => Auth::id(),
    'problem_id' => $problem->id,
    'content' => $request->content,
    'parent_id' => $request->parent_id,
    'is_expert' => Auth::user()->role === 'expert'
]);

        return back()->with('success', 'Comment posted.');
    }
}

