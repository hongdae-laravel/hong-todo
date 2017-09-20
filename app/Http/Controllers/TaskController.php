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
        $this->tasks = $tasks;
    }

    public function index(Request $request)
    {
        $task = null;
        $tasks = null;

        if($request->user()) {
            $tasks = $this->tasks->forUser($request->user());
        }

        return view('tasks.index', [
            'tasks' => $tasks,
            'task' => $task,
            'now' => time() // 현재시간
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        $request->user()->tasks()->create([
            'name' => $request->name,
            'due_date' => $request->due_date // 완료일 추가
        ]);

        return redirect('/tasks');
    }

    public function show(Task $task)
    {
        $tasks = Auth::user()->tasks()->get();
        return view('tasks.index', [
            'tasks' => $tasks,
            'task' => $task,
            'now' => time() // 현재시간
        ]);
    }

    public function update(StoreTaskRequest $request, $id)
    {
        $task = Task::find($id);
        $task->name = $request->input('name');
        $task->due_date = $request->input('due_date');
        $task->save();

        return redirect('/tasks');
    }

    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }

    public function storeTag(Request $request, $id)
    {
        $task = Task::find($id);
        $task->tag($request->input('tag'));
    }

    public function deleteTag(Request $request, $id)
    {
        $task = Task::find($id);
        $task->untag($request->input('tag'));
    }
}
