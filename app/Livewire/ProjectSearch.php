<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectSearch extends Component
{
    public $search = '';
    public $selected = '';
    public $beforeToday = false;
    public $current = false;

    public function mount(Request $request, $selected = '')
    {
        $this->selected = $request->session()->get('selected', '');
    }

    public function selectQuery(Request $request, $selected = '')
    {
        $this->selected = $selected;
        $request->session()->put('selected', $selected);
    }

    public function toggleProject(Request $request, $project_id)
    {
        if (!$request->session()->has('open_projects')) {
            $request->session()->put('open_projects', []);
        }
        if (in_array($project_id, $request->session()->get('open_projects', []))) {
            $save = $request->session()->get('open_projects', []);
            $request->session()->pull('open_projects', []);
            $request->session()->put('open_projects', array_diff($save, [$project_id]));
        } else {
            $request->session()->push('open_projects', $project_id);
        }
    }

    public function refreshProject()
    {
        $this->dispatch('$refresh');
    }

    public function deleteSession(Request $request)
    {
        $request->session()->put('open_projects', []);
        $request->session()->put('open_tasks', []);
    }

    public function render(Request $request)
    {
        $projects = null;
        if ($this->selected == 'after') {
            $projects = Project::where('name', 'like', '%' . $this->search . '%')
                ->whereDate('end', '<=', date('Y-m-d'))
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->get();
        } else if ($this->selected == 'before') {
            $projects = Project::where('name', 'like', '%' . $this->search . '%')
                ->whereDate('start', '<=', date('Y-m-d'))
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->get();
        } else if ($this->selected == 'current') {
            $projects = Project::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->get();
        } else {
            $projects = Project::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->orWhere('id', 'like', '%' . $this->search . '%')
                ->get();
        }

        return view('livewire.project-search', [
            'projects' => $projects
        ]);
    }
}
