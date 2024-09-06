<?php


namespace App\Services;

use App\Models\Task;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TaskService
{

    public function show($id)
    {
        try {
            $task = Task::findOrFail($id);
            return response()->json($task);
        }catch (Exception $exception) {
            throw new HttpResponseException(response()->json(['errors' => $errors], 422));
        }
    }

    public function subtask($id)
    {
        try {
            $task = Task::findOrFail($id);
            $list = DB::table('tasks')->where('type',$id)->get();
            return response()->json([$task,$list]);
        }catch (Exception $exception) {
            throw new HttpResponseException(response()->json(['errors' => $errors], 422));
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' =>       'required|string|max:255',
            'description' => 'nullable|string',
            'status' =>      'required|in:pending,in_progress,completed',
            'due_date' =>    'nullable|date',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new HttpResponseException(response()->json(['errors' => $errors], 422));
        }
        $data = $validator->validated();
        $task = Task::create($data);

        return response()->json($task, 201);

    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new HttpResponseException(response()->json(['errors' => $errors], 422));
        }

        $task = Task::findOrFail($id);
        $task->update($validator->validated());

        return response()->json($task);
    }

}
