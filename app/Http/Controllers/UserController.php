<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('job.project', 'job.task')->find($id);
        if ($user) {
            return view('users.show', ['user' => $user, 'jobs' => $user->job]);
        } else {
            return "Kein Benutzer mit der Nummer $id. Er wurde gelöscht oder nicht erstellt.";
        }
    }
}
