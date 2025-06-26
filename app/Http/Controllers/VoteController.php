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

        $userId = Auth::id();
        $reporter = $problem->user;

        // Check if vote already exists
        $existingVote = Vote::where('user_id', $userId)
                            ->where('problem_id', $problem->id)
                            ->first();

        if ($existingVote) {
            // If vote type hasn't changed, do nothing
            if ($existingVote->type === $request->type) {
                return back()->with('info', 'You already voted this way.');
            }

            // If switching from up to down
            if ($existingVote->type === 'up' && $request->type === 'down') {
                $reporter->decrement('reward_points', 10);
            }

            // If switching from down to up
            if ($existingVote->type === 'down' && $request->type === 'up') {
                $reporter->increment('reward_points', 10);
            }

            // Update vote
            $existingVote->update(['type' => $request->type]);

        } else {
            // First-time vote
            Vote::create([
                'user_id' => $userId,
                'problem_id' => $problem->id,
                'type' => $request->type
            ]);

            // Reward only on new upvotes
            if ($request->type === 'up') {
                $reporter->increment('reward_points', 10);
            }
        }

        return back()->with('success', 'Vote submitted.');
    }
}
