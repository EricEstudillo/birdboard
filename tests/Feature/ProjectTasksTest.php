<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
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
    $this->signIn();
    $project = \factory(Project::class)->create(['owner_id' => auth()->id()]);
    
    $attributes = ['body' => 'Test task'];
    $this->post($project->path() . '/tasks', $attributes);
    $this->get($project->path() . '/tasks')
      ->assertSee($attributes['body']);
  }
  
  /**
   * @test
   */
  public function a_task_requires_a_body()
  {
    $this->signIn();
    $project = \factory(Project::class)->create(['owner_id' => auth()->id()]);
    $task = \factory(Task::class)->raw(['body' => '']);
    
    $this->post($project->path() . '/tasks', $task)->assertSessionHasErrors('body');
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
}
