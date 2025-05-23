<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Problem;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
{
    return view('admin.dashboard', [
        'totalUsers' => \App\Models\User::count(),
        'totalProblems' => \App\Models\Problem::count(),
        'totalVotes' => \App\Models\Vote::count(),
        'totalComments' => \App\Models\Comment::count(),
    ]);
}




public function users(Request $request)
{
    $query = User::query();

    // Filter by role
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }
    // Filter by name search
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $users = $query->orderBy('name')->paginate(10)->withQueryString();

    return view('admin.users', compact('users'));
}

public function toggleBan(User $user)
{
    $user->is_banned = !$user->is_banned;
    $user->save();

    return redirect()->back()->with('success', 'User ' . ($user->is_banned ? 'banned' : 'unbanned') . ' successfully.');
}

// ...existing code...

public function updateUserRole(Request $request, User $user)
{
    $request->validate(['role' => 'required|in:citizen,expert,authority,admin']);

    $user->role = $request->role;
    $user->save();

    return back()->with('success', 'User role updated.');
}

public function problems()
{
    $problems = Problem::with('user')->latest()->get();
    $authorities = User::where('role', 'authority')->get();

    return view('admin.problems', compact('problems', 'authorities'));
}

public function assignProblem(Request $request, Problem $problem)
{
    $request->validate(['assigned_to' => 'required|string']);

    $problem->assigned_to = $request->assigned_to;
    $problem->save();

    return back()->with('success', 'Problem assigned successfully.');
}

public function updateStatus(Request $request, Problem $problem)
{
    $request->validate(['status' => 'required|in:pending,in_progress,resolved']);

    $problem->status = $request->status;
    $problem->save();

    return back()->with('success', 'Problem status updated.');
}

}
