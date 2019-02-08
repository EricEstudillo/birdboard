<?php

namespace App\Observers;

use App\Activity;
use App\Project;

class ProjectObserver
{
  
  /**
   * Handle the project "created" event.
   *
   * @param  \App\Project $project
   * @return void
   */
  public function created(Project $project)
  {
    $this->recordActivity($project,'created');
  }
  
  /**
   * Handle the project "updated" event.
   *
   * @param  \App\Project $project
   * @return void
   */
  public function updated(Project $project)
  {
    $this->recordActivity($project,'updated');
  }
  
  /**
   * @param Project $project
   */
  private function recordActivity( Project $project, string $description): void
  {
    Activity::create(
      [
        'description' => $description,
        'project_id' => $project->id
      ]
    );
  }
  
}
