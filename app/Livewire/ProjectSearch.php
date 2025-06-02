<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProjectSearch extends Component
{
    public $search = '';
    public $open_projects = [];
    public $open_tasks = [];
    public $open_jobs = [];

    public function mount()
    {
        // if (Session::get('open_projects') == null) {
        //     Session::put('open_projects', []);
        // }
        // if (Session::get('open_tasks') == null) {
        //     Session::put('open_tasks', []);
        // }
        // if (Session::get('open_jobs') == null) {
        //     Session::put('open_jobs', []);
        // }
        if (Session::get('open_projects') != null || Session::get('open_tasks') != null || Session::get('open_jobs') != null) {
            $this->open_projects = Session::get('open_projects', []);
            $this->open_tasks = Session::get('open_tasks', []);
            $this->open_jobs = Session::get('open_jobs', []);
        }
    }

    public function toggleProject(Request $request, $project_id)
    {
        if (in_array($project_id, Session::get('open_projects', []))) {
            $save = Session::get('open_projects', []);
            Session::pull('open_projects');
            Session::put('open_projects', array_diff($save, [$project_id]));
        } else {
            Session::push('open_projects', $project_id);
        }

        return redirect()->back();
    }
    public function toggleTask(Request $request, $tasks_id)
    {
        if (in_array($tasks_id, Session::get('open_tasks', []))) {
            $save = Session::get('open_tasks', []);
            Session::pull('open_tasks');
            Session::put('open_tasks', array_diff($save, [$tasks_id]));
        } else {
            Session::push('open_tasks', $tasks_id);
        }

        return redirect()->back();
    }

    public function toggleJob(Request $request, $job_id)
    {
        if (in_array($job_id, Session::get('open_jobs', []))) {
            $save = Session::get('open_jobs', []);
            Session::pull('open_jobs');
            Session::put('open_jobs', array_diff($save, [$job_id]));
        } else {
            Session::push('open_jobs', $job_id);
        }
        return redirect()->back();
    }


    public function render(Request $request)
    {
        $projects = Project::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->get();

        Session::put('open_projects', $this->open_projects);
        Session::put('open_tasks', $this->open_tasks);
        Session::put('open_jobs', $this->open_jobs);

        return view('livewire.project-search', [
            'projects' => $projects
        ]);
    }
}
