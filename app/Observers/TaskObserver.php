<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
  /**
   * Handle the task "created" event.
   *
   * @param  \App\Task $task
   * @return void
   */
  public function created(Task $task): void
  {
    $task->project->recordActivity('task created');
  }
  
  public function deleted(Task $task): void
  {
    $task->project->recordActivity('task deleted');
  }
}
