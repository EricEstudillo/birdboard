<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
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
    $response = $this->post('/projects', $attributes);
    
    $project = Project::where($attributes)->first();
    $response->assertRedirect($project->path());
    
    $this->get($project->path())
      ->assertSee($attributes['title'])
      ->assertSee($attributes['description'])
      ->assertSee($attributes['notes'])
      ->assertSee($attributes['owner_id']);
  }
  
  /**
   * @test
   */
  public function a_user_can_update_a_project()
  {
    $project = ProjectFactory::create();
    $attributes = ['notes' => 'new note',];
    
    $this->actingAs($project->owner)
      ->patch($project->path(), $attributes)
      ->assertRedirect($project->path());
    
    $this->assertDatabaseHas('projects', $attributes);
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
    
    $response = $this->post('/projects', $attributes);
    $project = Project::where($attributes)->first();
    $response->assertRedirect($project->path());
  }
  
  /**
   * @test
   */
  public function a_user_can_view_their_projects()
  {
    $project = ProjectFactory::create();
    $this->actingAs($project->owner)
      ->get($project->path())
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
  
  /**
   * @test
   */
  public function an_authenticated_user_cannot_updte_the_projects_of_others()
  {
    $this->signIn();
    $project = factory(Project::class)->create();
    $attributes = ['notes' => 'new note'];
    $this->patch($project->path(), $attributes)
      ->assertStatus(403);
  }
}
