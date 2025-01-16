<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::query()
        ->when(request('search'), function($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        })
        ->when(request('status') !== null, function($query) {
            $query->where('is_completed', request('status'));
        })
        ->orderBy('created_at', direction: 'desc')
        ->paginate(10);

        return view('tasks.tasks', compact('tasks'));
    }
    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $data['is_completed'] = $request->has('is_completed') ? 1 : 0;

        Task::create($data);

        return redirect('/tasks');
    }
    public function edit(Task $id)
    {
        return view('tasks.edit', compact('id'));
    }

    public function update(Task $id)
    {
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $data['is_completed'] = request()->has('is_completed') ? 1 : 0;

        $id->update($data);

        return redirect('/tasks');
    }


    public function destroy(Task $id)
    {
        $id->delete();

        return redirect('/tasks');
    }

    public function statistics()
{
    $stats = [
        'total' => Task::count(),
        'completed' => Task::where('is_completed', 1)->count(),
        'pending' => Task::where('is_completed', 0)->count(),
    ];

    return view('tasks.statistics', compact('stats'));
}
}
