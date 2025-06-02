<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TaskCreate extends Component
{
    public $name = '';
    public $description = '';
    public $project_id = null;
    public $task = null;

    protected $rules = [
        'name' => 'required|min:4',
        'description' => 'required|min:10',
        'project_id' => 'required|integer',
    ];

    public function mount($project_id = null)
    {
        if (!$project_id) return redirect()->route('home');
        $this->project_id = $project_id;
    }

    public function save()
    {
        $this->validate();

        $this->task = new Task();

        $this->task->name = $this->name;
        $this->task->description = $this->description;
        $this->task->project_id = $this->project_id;
        $this->task->save();


        session()->flash('message', 'Task created successfully.');

        return redirect()->route('home'); # change
    }

    public function render()
    {
        return view('livewire.task-create');
    }
}
