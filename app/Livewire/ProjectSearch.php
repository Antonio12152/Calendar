<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ProjectSearch extends Component
{
    public $search = '';
    public $selected = '';
    public $beforeToday = false;
    public $current = false;
    public $openProjects = [];

    public function mount(Request $request, $selected = '')
    {
        $this->selected = $request->session()->get('selected', '');
    }

    public function selectQuery(Request $request, $selected = '')
    {
        $this->selected = $selected;
        $request->session()->put('selected', $selected);
    }

    public function toggleProject($project_id)
    {
        if (!session()->has('open_projects')) {
            session()->put('open_projects', []);
        }
        if (in_array($project_id, session()->get('open_projects', []))) {
            $save = session()->get('open_projects', []);
            session()->pull('open_projects', []);
            session()->put('open_projects', array_diff($save, [$project_id]));
        } else {
            session()->push('open_projects', $project_id);
        }
        $this->dispatch('refresh_component');
    }

    public function refreshProject()
    {
        //$this->dispatch('$refresh');
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
            $projects = DB::table('projects')
                ->when($this->search, function (Builder $query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                })
                ->whereDate('end', '>=', date('Y-m-d h:m:s'))
                ->get();
        } else if ($this->selected == 'before') {
            $projects = DB::table('projects')
                ->when($this->search, function (Builder $query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                })
                ->whereDate('start', '<=', date('Y-m-d h:m:s'))
                ->get();
        } else if ($this->selected == 'current') {
            $projects = DB::table('projects')
                ->when($this->search, function (Builder $query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('id', 'like', '%' . $search . '%');
                })
                ->whereDate('start', '<=', date('Y-m-d h:m:s'))
                ->whereDate('end', '>=', date('Y-m-d h:m:s'))
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
