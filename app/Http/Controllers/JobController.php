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
            return "Kein Job mit der Nummer $task_id.";
        }
    }

    /**
     * Show the form for creating a new resource. $project_id = null, $task_id = null change
     */
    public function create(Request $request)
    {
        $project_id = $request->query('project_id');
        $task_id = $request->query('task_id');
        return view('jobs.create', ['project_id' => $project_id, 'task_id' => $task_id]);
    }

    public function edit($project_id, $task_id, $job_id)
    {
        $search_by_id = Job::where('id', $job_id)->first();
        if ($search_by_id) {
            return view('jobs.edit', ['job' => $search_by_id]);
        } else {
            return "Kein Job mit der Nummer $job_id. Er wurde gelöscht oder nicht erstellt.";
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
            return "Kein Job mit der Nummer $job_id. Er wurde gelöscht oder nicht erstellt.";
        }
    }
}
