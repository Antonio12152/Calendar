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
        $this->open_projects = Session::get('open_projects');
        $this->open_tasks = Session::get('open_tasks');
        $this->open_jobs = Session::get('open_jobs');
    }

    public function toggleProject($project_id)
    {
        Session::put('open_projects', $project_id);
    }
    public function toggleTask($open_tasks)
    {
        Session::put('open_tasks', $open_tasks);
    }

    public function toggleJob($open_jobs)
    {
        Session::put('open_jobs', $open_jobs);
    }


    public function render()
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
