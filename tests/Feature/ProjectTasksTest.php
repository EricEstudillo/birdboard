<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
  use RefreshDatabase;
  
  /**
   * @test
   */
  public function a_project_can_have_tasks()
  {
    $project = ProjectFactory::create();
    
    $attributes = ['body' => 'Test task'];
    $this->actingAs($project->owner)
      ->post($project->path() . '/tasks', $attributes);
    $this->get($project->path() . '/tasks')
      ->assertSee($attributes['body']);
  }
  
  /**
   * @test
   */
  public function a_task_requires_a_body()
  {
    $project = ProjectFactory::create();
    $task = \factory(Task::class)->raw(['body' => '']);
    
    $this->actingAs($project->owner)
      ->post($project->path() . '/tasks', $task)
      ->assertSessionHasErrors('body');
  }
  
  /**
   * @test
   */
  public function a_task_can_be_completed()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $task = $project->tasks->first();
    $attributes = ['body' => 'updated body', 'completed' => true];
    
    $this->actingAs($project->owner)->patch($task->path(), $attributes);
    $this->get($task->project->path())->assertSee($attributes['body']);
  }
  
  /**
   * @test
   */
  public function a_task_can_be_marked_as_incomplete()
  {
    $task = \factory(Task::class)->create(['completed' => true]);
    $project = $task->project;
  
    $attributes = ['body' => 'updated body', 'completed' => false];
    $this->actingAs($project->owner)->patch($task->path(), $attributes);
    $this->get($task->project->path())->assertSee($attributes['body']);
  }
  
  /**
   * @test
   */
  public function only_the_owner_of_a_project_may_add_tasks()
  {
    $this->signIn();
    $project = \factory(Project::class)->create();
    $task = \factory(Task::class)->raw();
    $this->post($project->path() . '/tasks', $task)->assertStatus(403);
  }
  
  /**
   * @test
   */
  public function a_task_can_be_updated()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $task = $project->tasks->first();
    $attributes = ['body' => 'updated body', 'completed' => true];
    
    $this->actingAs($project->owner)->patch($task->path(), $attributes);
    $this->get($task->project->path())->assertSee($attributes['body']);
  }
  
  /**
   * @test
   */
  public function only_the_owner_of_a_project_may_update_tasks()
  {
    $project = ProjectFactory::withTasks(1)->create();
    $this->signIn();
    $this->patch($project->tasks->first()->path(), ['body' => 'updated body'])->assertStatus(403);
  }
}
