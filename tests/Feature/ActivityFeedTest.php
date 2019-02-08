<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
  use RefreshDatabase;
  
  /**
   * @test
   */
  public function creating_a_project_generates_activity()
  {
    $project = ProjectFactory::create();
    $this->assertCount(1, $project->activity);
  }
  
  /**
   * @test
   */
  public function updating_a_project_generates_activity()
  {
    $project = ProjectFactory::create();
    $project->update(['title' => 'updated title']);
    $this->assertCount(2, $project->activity);
    $this->assertEquals('updated', $project->activity->last()->description);
  }
  
  /**
   * @test
   */
  public function creating_a_new_task_records_project_activity()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $this->assertCount(2, $project->activity);
    $this->assertEquals('task created', $project->activity->last()->description);
  }
  
  /**
   * @test
   */
  public function completing_a_task_records_project_activity()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $task = $project->tasks->first();
    $task->complete();
    $this->assertCount(3, $project->activity);
    $this->assertEquals('completed_task', $project->activity->last()->description);
  }
}
