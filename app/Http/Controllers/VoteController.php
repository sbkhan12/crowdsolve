<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Problem;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request, Problem $problem)
    {
        $request->validate([
            'type' => 'required|in:up,down'
        ]);

        $vote = Vote::updateOrCreate(
            ['user_id' => Auth::id(), 'problem_id' => $problem->id],
            ['type' => $request->type]
        );

        return back()->with('success', 'Vote submitted.');
    }
}

