<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Http\Requests\StoreTaskRequest;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $tasks;

    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;


    }

    public function index(Request $request)
    {
        $task = null;

        return view('tasks.index', [
            'tasks' => $this->tasks->forUser($request->user()),
            'task' => $task,
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    public function show(Task $task)
    {
        $tasks = Auth::user()->tasks()->get();
        return view('tasks.index', ['tasks' => $tasks, 'task' => $task]);
    }

    public function update(StoreTaskRequest $request, $id)
    {
        $task = Task::find($id);
        $task->name = $request->input('name');
        $task->save();

        return redirect('/tasks');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
