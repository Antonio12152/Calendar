<?php

namespace App\Livewire;

use App\Models\Job;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Contracts\Database\Query\Builder;

class ProjectIndex extends Component
{
    public $selected = '';
    public function selectQuery($selected = '')
    {
        $this->selected = $selected;
    }
    public function render()
    {
        $projects = null;
        $colors = ['blue', 'green', 'navy', 'indigo', 'dodgerblue', 'mediumorchid', 'lightslategray', 'teal'];
        if ($this->selected == 'jobs') {
            $jobs = Job::with('user')->whereHas('user', function ($query) {
                $query->where('user_id', '=', Auth::id());
            })->get();
            $projects = $jobs->map(function ($p) use ($colors) {
                return [
                    'id' => $p->id,
                    'title' => $p->name,
                    'start' => $p->start,
                    'end' => $p->end,
                    'color' => $colors[$p->id % count($colors)],
                ];
            });
        } else {
            $pro = Project::with(['task'])->get();
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
        }

        return view('livewire.project-index', [
            'projects' => $projects
        ]);
    }
}
