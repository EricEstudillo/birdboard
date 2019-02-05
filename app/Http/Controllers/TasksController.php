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
  
  public function store(Project $project, Request $request )
  {
    $attributes = $request->validate([
      'body' => 'required',
    ]);
    $project->addTask(\request('body'));
//    Task::create(['body' => \request('body'), 'project_id' => $project->id]);
  }
}
