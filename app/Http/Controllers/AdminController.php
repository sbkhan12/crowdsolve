<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Problem;
use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AdminController extends Controller
{
   public function dashboard()
{
    $months = collect(range(0, 5))->map(function ($i) {
        return now()->subMonths($i)->startOfMonth();
    })->reverse();

    $counts = $months->map(function ($month) {
        return Problem::whereBetween('created_at', [
            $month,
            $month->copy()->endOfMonth()
        ])->count();
    });

    return view('admin.dashboard', [
        'totalUsers' => User::count(),
        'totalProblems' => Problem::count(),
        'totalVotes' => Vote::count(),
        'totalComments' => Comment::count(),
        'problemStats' => [
            'months' => $months->map(fn($m) => $m->format('M Y')),
            'counts' => $counts
        ]
    ]);
}


    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

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

        return back()->with('success', 'User ' . ($user->is_banned ? 'banned' : 'unbanned') . ' successfully.');
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:citizen,expert,authority,admin'
        ]);

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
        $request->validate([
            'assigned_to' => 'required|string'
        ]);

        $problem->assigned_to = $request->assigned_to;
        $problem->save();

        return back()->with('success', 'Problem assigned successfully.');
    }

    public function updateStatus(Request $request, Problem $problem)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $problem->status = $request->status;
        $problem->save();

        return back()->with('success', 'Problem status updated.');
    }

    public function analytics()
    {
        // Load this in admin.analytics blade view
        return view('admin.analytics', [
            'problemTrend' => Problem::selectRaw('DATE(created_at) as date, count(*) as total')
                ->groupBy('date')->orderBy('date')->get(),
            'topUsers' => User::withCount('votes')->orderBy('votes_count', 'desc')->take(5)->get()
        ]);
    }

    public function reports()
    {
        // Assume a reports system is implemented, or add dummy content
        return view('admin.reports', [
            'problems' => Problem::with('user')->where('status', '!=', 'resolved')->get()
        ]);
    }

    // Optional: Reward Badge logic (for frontend use)
    public function rewardBadges()
    {
        $users = User::withCount(['votes' => function ($q) {
            $q->where('type', 'up');
        }])->get();

        foreach ($users as $user) {
            if ($user->votes_count >= 100) {
                $user->badge = '🏆 Super Contributor';
            } elseif ($user->votes_count >= 50) {
                $user->badge = '🎖️ Active Helper';
            } elseif ($user->votes_count >= 10) {
                $user->badge = '💬 Community Member';
            } else {
                $user->badge = null;
            }
        }

        return $users;
    }
}
