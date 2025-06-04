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

    public function mount()
    {
        if (Session::get('open_projects') != null) {
            $this->open_projects = Session::get('open_projects', []);
        }
    }

    public function toggleProject(Request $request, $project_id)
    {
        if (in_array($project_id, Session::get('open_projects', []))) {
            $save = Session::get('open_projects', []);
            Session::pull('open_projects');
            Session::put('open_projects', array_diff($save, [$project_id]));
        } else {
            Session::push('open_projects', [$project_id] = $project_id);
        }
    }

    public function render(Request $request)
    {
        $projects = Project::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('description', 'like', '%' . $this->search . '%')
            ->orWhere('id', 'like', '%' . $this->search . '%')
            ->get();

        if (Session::get('open_projects') == null) {
            Session::put('open_projects', []);
        }

        return view('livewire.project-search', [
            'projects' => $projects
        ]);
    }
}
