<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
  public function index(Project $project)
  {
    return view('projects.show', compact('project'));
  }
  
  public function store(Project $project, Request $request)
  {
    $request->validate(['body' => 'required']);
    
    if (\auth()->user()->isNot($project->owner)) {
      abort(403);
    }
    $project->addTask(\request('body'));
    return \redirect($project->path());
  }
  
  public function update(Project $project, Task $task, Request $request)
  {
    $request->validate(['body' => 'required']);
    if (\auth()->user()->isNot($project->owner)) {
      abort(403);
    }
    $task->update([
      'body' => request('body'),
      'completed' => request()->has('completed')
    ]);
    
    return \redirect($project->path());
  }
}
