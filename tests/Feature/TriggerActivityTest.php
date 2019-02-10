<?php

namespace Tests\Feature;

use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
  use RefreshDatabase;
  
  /**
   * @test
   */
  public function creating_a_project()
  {
    $project = ProjectFactory::create();
    $this->assertCount(1, $project->activity);
    tap($project->activity->last(), function ($activity) {
      $this->assertEquals('created',$activity->description);
      $this->assertNull($activity->changes);
    });
  }
  
  /**
   * @test
   */
  public function updating_a_project()
  {
    $project = ProjectFactory::create();
    $originalProject = $project->title;
    $project->update(['title' => 'updated title']);
    $this->assertCount(2, $project->activity);
    tap($project->activity->last(), function ($activity) use ($originalProject) {
      $this->assertEquals('updated', $activity->description);
      $expected = [
        'before' => ['title' => $originalProject],
        'after' => ['title' => 'updated title']
      ];
      $this->assertEquals($expected, $activity->changes);
    });
  }
  
  /**
   * @test
   */
  public function creating_a_new_task()
  {
    $project = ProjectFactory::create();
    $project->addTask('some task');
    $this->assertCount(2, $project->activity);
    \tap($project->activity->last(), function ($activity) {
      $this->assertEquals('task_created', $activity->description);
      $this->assertInstanceOf(Task::class, $activity->subject);
      $this->assertEquals('some task', $activity->subject->body);
    });
  }
  
  /**
   * @test
   */
  public function completing_a_task()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $task = $project->tasks->first();
    $task->complete();
    $this->assertCount(3, $project->activity);
    $this->assertEquals('completed_task', $project->activity->last()->description);
  }
  
  /**
   * @test
   */
  public function uncompleting_a_task()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $task = $project->tasks->first();
    $task->complete();
    $task->incomplete();
    $this->assertCount(4, $project->activity);
    $this->assertEquals('uncompleted_task', $project->activity->last()->description);
  }
  
  /**
   * @test
   */
  public function deleting_a_task()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $task = $project->tasks->first();
    $task->delete();
    
    $this->assertCount(3, $project->activity);
    $this->assertEquals('task_deleted', $project->activity->last()->description);
  }
}
