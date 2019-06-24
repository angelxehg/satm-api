<?php

namespace App\Http\Controllers\Task;

use App\Task;
use App\Component;
use App\User;
use App\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache as IlluminateCache;

class TaskController extends ApiController
{
    // Show all tasks
    public function index()
    {
        if ($this->isLoggedIn()) {
            $cached = IlluminateCache::remember('tasks', 10, function () {
                $tasks = Task::all();
                $synthKey = $this->getSynthTasks();
                return [
                    'data' => $tasks,
                    'synthKey' => $synthKey
                ];
            });
            $data = $cached['data'];
            $synthKey = $cached['synthKey'];
            return $this->showMany($data, "All the tasks", $synthKey);
        }
    }

    // Create a task
    public function store(Request $request)
    {
        if ($this->isAdminAndLoggedIn()) {
            $rules = [
                'title' => 'required|min:2|max:150',
                'description' => 'required|min:2|max:150',
                'priority' => 'required|integer|min:0|max:3',
                'dueDate' => 'required|date',
                'component_id' => 'required|integer|min:1',
                'user_id' => 'required|integer|min:1'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            $component = Component::findorFail($fields['component_id']);
            $user = User::findorFail($fields['user_id']);
            $task = new task($fields);
            $task->component()->associate($component);
            $task->user()->associate($user);
            $task->save();
            $this->synthTasks();
            return $this->showOne($task, "Task created");
        }
    }

    // Update a user
    public function update(Request $request, $id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $task = Task::findorFail($id);
            $rules = [
                'title' => 'min:2|max:150',
                'description' => 'min:2|max:150',
                'priority' => 'integer|min:0|max:3',
                'dueDate' => 'date',
                'component_id' => 'integer|min:1',
                'user_id' => 'integer|min:1'
            ];
            $this->validate($request, $rules);
            $fields = $request->all();
            if ($request->has('component_id')) {
                $component = Component::findorFail($fields['component_id']);
                $task->component()->associate($component);
            }
            if ($request->has('user_id')) {
                $user = User::findorFail($fields['user_id']);
                $task->user()->associate($user);
            }
            if ($request->has('put_material_id')) {
                $material = Material::findorFail($fields['put_material_id']);
                $task->materials()->attach($material);
            }
            $task->update($fields);
            $this->synthTasks();
            return $this->showOne($task, "Task updated");
        }
    }

    // Delete a user
    public function destroy($id)
    {
        if ($this->isAdminAndLoggedIn()) {
            $task = Task::findorFail($id);
            $task->delete();
            $this->synthTasks();
            return $this->showOne($task, "Task deleted");
        }
    }
}
