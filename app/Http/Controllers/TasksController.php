<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class TasksController extends Controller
{
  public function index(Project $project)
  {
    return view('projects.show', compact('project'));
  }
  
  public function store(Project $project, Request $request)
  {
    $request->validate(['body' => 'required',]);
    
    if (\auth()->user()->isNot($project->owner)) {
      abort(403);
    }
    $project->addTask(\request('body'));
    return \redirect($project->path());
  }
}
