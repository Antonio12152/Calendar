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
        $search_by_id = User::where('id', $id)->first();
        if ($search_by_id) {
            $jobs = Job::user()->where('user_id', $id)->get();
            dd($jobs);
            return view('users.show', ['user' => $search_by_id]);
        } else {
            return "No user at nummer $id. It was deleted or wasn't created.";
        }
    }
}
