<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\TaskService;
use Exception;


class TaskController extends Controller
{

    protected  $taskService;

    public function __construct( TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    public function index(Request $request)
    {
        $query = Task::query();
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('due_date')) {
            $query->whereDate('due_date', $request->input('due_date'));
        }

        $tasks = $query->with('user')->get();

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        return $this->taskService->store($request);
    }

    public function subtask($id)
    {
        return $this->taskService->subtask($id);
    }


    public function show($id)
    {
        return $this->taskService->show($id);
    }

    public function update(Request $request, $id)
    {
        return $this->taskService->update($request, $id);
    }

    public function destroy($id)
    {
        Task::findOrFail($id)->delete();

        return response()->noContent();
    }
}
