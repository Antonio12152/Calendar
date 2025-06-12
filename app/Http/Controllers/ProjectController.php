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
        $projects = [];

        $pro = Project::with(['task'])->get();
        $colors = ['blue', 'green', 'navy', 'indigo', 'dodgerblue', 'mediumorchid', 'lightslategray', 'teal'];
        $projects = $pro->map(function ($p) use ($colors) {
            return [
                'id' => $p->id,
                'title' => $p->name,
                'start' => $p->start,
                'end' => $p->end,
                'color' => $colors[$p->id % count($colors)],
                'extendedProps' => [
                    'title' => $p->name,
                    'tasks' =>
                    $p->task ? $p->task->map(function ($t) {
                        return [
                            'id' => $t->id,
                            'title' => $t->name,
                            'description' => $t->description,
                        ];
                    }) : []
                ]
            ];
        });

        return view('projects.index', compact('projects'));
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
