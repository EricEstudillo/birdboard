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
    $task->recordActivity('task_created');
  }
  
  public function deleted(Task $task): void
  {
    $task->recordActivity('task_deleted');
  }
}
