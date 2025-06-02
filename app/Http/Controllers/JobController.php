<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $task_id)
    {
        $jobs = Job::where('task_id', $task_id)->get();
        if ($jobs) {
            return view('tasks.show', compact('jobs'));
        } else {
            return "No Job at project nummer $task_id.";
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id, $task_id)
    {
        return view('jobs.create', ['project_id' => $project_id, 'task_id' => $task_id]);
    }

    public function edit($project_id, $task_id, $job_id)
    {
        $search_by_id = Job::where('id', $job_id)->first();
        if ($search_by_id) {
            return view('jobs.edit', ['job' => $search_by_id]);
        } else {
            return "No Job at nummer $job_id. It was deleted or wasn't created.";
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($project_id, $task_id, $job_id)
    {
        $search_by_id = Job::where('id', $job_id)->first();
        if ($search_by_id) {
            $search_by_id->delete();

            return redirect()->route('home', ['project_id' => $project_id, 'task_id' => $task_id]); # change
        } else {
            return "No job at nummer $job_id. There is nothing delete.";
        }
    }
}
