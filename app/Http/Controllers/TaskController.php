<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Paginate the authenticated user's tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = Auth::user()
            ->tasks()
            ->orderBy('is_done')
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('tasks', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a new incomplete task for the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required|string|max:255',
        ]);

        Auth::user()->tasks()->create([
            'title' => $data['title'],
            'is_done' => false,
        ]);

        session()->flash('status', "Task {$request['title']} Created!");

        return redirect('/tasks');
    }

    /**
     * Mark the given task as complete and redirect to tasks index.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Task $task)
    {
        $task->is_done = true;
        $task->save();

        session()->flash('status', "Task {$task->title} Completed!");

        return redirect('/tasks');
    }

    /**
     * Delete the given task and redirect to tasks index.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(Task $task)
    {
        $task->delete();

        session()->flash('status', "Task {$task->title} Deleted!");

        return redirect('/tasks');
    }
}
