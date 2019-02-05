<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
  use WithFaker;
  use RefreshDatabase;
  
  /**
   * @test
   */
  public function guest_cannot_manage_projects()
  {
    $project = factory(Project::class)->create();
    
    $this->post('/projects', $project->toArray())->assertRedirect('/login');
    $this->get('/projects')->assertRedirect('/login');
    $this->get($project->path())->assertRedirect('/login');
    $this->get('/projects/create')->assertRedirect('/login');
  }
  
  /**
   * @test
   */
  public function a_user_can_create_a_project()
  {
    $this->signIn();
    $attributes = factory(Project::class)->raw(['owner_id' => auth()->id()]);
    $this->post('/projects', $attributes)->assertRedirect('/projects');
    
    $this->assertDatabaseHas('projects', $attributes);
    
    $this->get('/projects')->assertSee($attributes['title']);
  }
  
  /**
   * @test
   */
  public function a_project_requires_a_title()
  {
    $this->signIn();
    $attributes = factory(Project::class)->raw(['title' => '', 'owner_id' => auth()->id()]);
    $this->post('/projects', $attributes)->assertSessionHasErrors('title');
  }
  
  /**
   * @test
   */
  public function a_project_requires_a_description()
  {
    $this->signIn();
    $attributes = factory(Project::class)->raw(['description' => '', 'owner_id' => auth()->id()]);
    
    $this->post('/projects', $attributes)->assertSessionHasErrors('description');
  }
  
  
  /**
   * @test
   */
  public function a_project_requires_an_owner()
  {
    $this->signIn();
    $attributes = factory(Project::class)->raw(['owner_id' => auth()->id()]);
    
    $this->post('/projects', $attributes)
      ->assertRedirect('/projects');
  }
  
  /**
   * @test
   */
  public function a_user_can_view_their_projects()
  {
    $this->signIn();
    $project = factory(Project::class)->create(['owner_id' => \auth()->id()]);
    $this->get($project->path())
      ->assertSee($project->title)
      ->assertSee(\substr($project->description, 0, 100));
  }
  
  /**
   * @test
   */
  public function an_authenticated_user_cannot_view_the_projects_of_others()
  {
    $this->signIn();
    $project = factory(Project::class)->create();
    
    $this->get($project->path())
      ->assertStatus(403);
  }
}
