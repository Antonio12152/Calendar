<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index');
    }
    public function create()
    {
        return view('projects.create');
    }

    public function edit($project_id)
    {
        $search_by_id = Project::where('id', $project_id)->first();
        if ($search_by_id) {
            return view('projects.edit', ['project' => $search_by_id]);
        } else {
            return "Kein Projekt bei Nummer $project_id. Es wurde gelöscht oder nicht erstellt.";
        }
    }

    public function show($project_id)
    {
        $search_by_id = Project::where('id', $project_id)->first();
        if ($search_by_id) {
            $tasks = Task::where('project_id', $project_id)->get();
            return view('projects.show', ['project' => $search_by_id, 'tasks' => $tasks]); #change
        } else {
            return "Kein Projekt bei Nummer $project_id. Es wurde gelöscht oder nicht erstellt.";
        }
    }

    public function update(Request $request, Project $projects)
    {
        $projects->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'start' => $request->input('start'),
            'end' => $request->input('end')
        ]);

        return redirect()->route('home');
    }

    public function destroy($project_id)
    {
        $search_by_id = Project::where('id', $project_id)->first();
        if ($search_by_id) {
            $search_by_id->delete();

            return redirect()->route('home');
        } else {
            return "Kein Projekt bei Nummer $project_id. Es wurde gelöscht oder nicht erstellt.";
        }
    }
}
