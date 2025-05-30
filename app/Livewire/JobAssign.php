<?php

namespace App\Livewire;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class JobAssign extends Component
{
    public $job = null;
    public $job_id = null;

    public function mount($job_id)
    {
        $this->job = Job::find($job_id);
    }

    public function attach($job_id)
    {
        $user = Auth::user();
        $this->job = Job::find($job_id);

        $this->job->user()->attach($user->id);

        return redirect()->back();
    }

    public function detach($job_id)
    {
        $user = Auth::user();
        $this->job = Job::find($job_id);

        $this->job->user()->detach($user->id);

        return redirect()->back();
    }

    public function render()
    {
        $assigned = $this->job->user->contains(Auth::id());

        return view('livewire.job-assign', ['assigned' => $assigned]);
    }
}
