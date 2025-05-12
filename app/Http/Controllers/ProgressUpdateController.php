<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use App\Models\ProgressUpdate;
use Illuminate\Support\Facades\Auth;

class ProgressUpdateController extends Controller
{
    public function store(Request $request, Problem $problem)
    {
        if (!in_array(Auth::user()->role, ['authority', 'moderator'])) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string'
        ]);

        ProgressUpdate::create([
            'user_id' => Auth::id(),
            'problem_id' => $problem->id,
            'message' => $request->message
        ]);

        return back()->with('success', 'Progress update added.');
    }
}

