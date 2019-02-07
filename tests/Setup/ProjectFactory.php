<?php


namespace Tests\Setup;


use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{
  
  private $tasksCount = 0;
  private $user;
  
  public function withTasks(int $count): ProjectFactory
  {
    $this->tasksCount = $count;
    return $this;
  }
  
  public function ownedBy(User $user): ProjectFactory
  {
    $this->user = $user;
    return $this;
  }
  
  public function create(): Project
  {
    $project = \factory(Project::class)->create([
      'owner_id' => $this->user ?? \factory(User::class)
    ]);
    
    \factory(Task::class, $this->tasksCount)->create([
      'project_id' => $project->id
    ]);
    return $project;
  }
}