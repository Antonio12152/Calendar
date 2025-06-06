<?php

namespace App\Livewire;

use App\Models\Task;
use Livewire\Component;

class TaskEdit extends Component
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

    protected $messages = [
        'name.required' => 'Das Namefeld ist erforderlich.',
        'description.required' => 'Das Beschreibungsfeld ist erforderlich.',
        'start.after' => 'Das Startfeld muss ein Datum nach dem aktuellen Datum und Uhrzeit sein.',
        'end.after' => 'Das Endefeld muss ein Datum nach dem Startfeld sein.',
    ];

    public function mount($task = null)
    {
        if ($task) {
            $this->task = $task;
            $this->name = $task->name;
            $this->description = $task->description;
            $this->project_id = $task->project_id;
        }
    }

    public function save()
    {
        $this->validate();

        $this->task->name = $this->name;
        $this->task->description = $this->description;
        $this->task->project_id = $this->project_id;
        $this->task->save();

        session()->flash('message', 'Task updated successfully.');

        return redirect()->route('home', $this->task->project_id); # change
    }
    public function render(Task $task)
    {
        return view('livewire.task-edit', [
            'task' => $task,
        ]);
    }
}
