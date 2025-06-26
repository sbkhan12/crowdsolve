<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Problem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProblemController extends Controller
{
    public function index(Request $request)
{
    $query = \App\Models\Problem::query();

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $problems = $query->latest()->paginate(6)->withQueryString();
    $categories = ['infrastructure', 'environment', 'safety', 'public services'];

    return view('problems.index', compact('problems', 'categories'));
}


    public function create()
    {
        return view('problems.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category' => 'required',
            'location' => 'nullable|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480'
        ]);

        $path = null;
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('problems', 'public');
        }

        Problem::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'media_path' => $path
        ]);

        return redirect()->route('problems.index')->with('success', 'Problem submitted successfully.');
    }

    public function show(Problem $problem)
    {
        return view('problems.show', compact('problem'));
    }

    public function edit(Problem $problem)
    {
        $this->authorize('update', $problem);
        return view('problems.edit', compact('problem'));
    }

    public function update(Request $request, Problem $problem)
    {
        $this->authorize('update', $problem);
        $problem->update($request->only('title', 'description', 'category', 'location'));
        return redirect()->route('problems.index')->with('success', 'Problem updated.');
    }

    public function destroy(Problem $problem)
    {
        $this->authorize('delete', $problem);
        $problem->delete();
        return redirect()->route('problems.index')->with('success', 'Problem deleted.');
    }

    public function manage(Problem $problem)
    {
        if (!in_array(Auth::user()->role, ['authority', 'expert'])) {
            abort(403);
        }

        return view('problems.manage', compact('problem'));
    }

    public function assign(Request $request, Problem $problem)
    {
        if (Auth::user()->role !== 'authority') {
            abort(403);
        }

        $problem->update([
            'status' => $request->status,
            'assigned_to' => Auth::user()->name
        ]);

        return redirect()->route('problems.show', $problem->id)->with('success', 'Problem updated by authority.');
    }
    // Removed duplicate index() method to fix redeclaration error

}
