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
    
    $this->authorize('update', $project);
    $project->addTask(\request('body'));
    
    return \redirect($project->path());
  }
  
  public function update(Project $project, Task $task, Request $request)
  {
    $request->validate(['body' => 'required']);
    $this->authorize('update', $task->project);
    $task->update([
      'body' => request('body'),
    ]);
    
    request('completed') ? $task->complete() : $task->incomplete();
    
    return \redirect($project->path());
  }
}
