<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $project_id)
    {
        $tasks = Task::where('project_id', $project_id)->get();
        if ($tasks) {
            return view('home', compact('task')); # change
        } else {
            return "No tasks at project nummer $project_id.";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        return view('tasks.create', ['project_id' => $project_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($project_id, $task_id)
    {
        $task = Task::where('id', $task_id)->first();
        if ($task) {
            $jobs = Job::where('task_id', $task_id)->get();
            return view('tasks.show', compact('task', 'jobs')); # change
        } else {
            return "Keine Aufgabe mit der Nummer $task_id.";
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($project_id, $task_id)
    {
        $search_by_id = Task::where('id', $task_id)->first();
        if ($search_by_id) {
            return view('tasks.edit', ['task' => $search_by_id]);
        } else {
            return "Keine Aufgabe mit der Nummer $task_id. Sie wurde gelöscht oder nicht erstellt.";
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $tasks)
    {
        $tasks->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
        ]);

        return redirect()->route('home'); # maybe change
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($project_id, $task_id)
    {
        $search_by_id = Task::where('id', $task_id)->first();
        if ($search_by_id) {
            $search_by_id->delete();

            return redirect()->route('home', ['project_id' => $project_id]);
        } else {
            return "Keine Aufgabe mit der Nummer $task_id. Sie wurde gelöscht oder nicht erstellt.";
        }
    }
}
