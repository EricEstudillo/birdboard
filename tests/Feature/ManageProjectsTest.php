<?php

namespace Tests\Feature;

use App\Project;
use App\User;
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
        $attributes = factory(Project::class)->raw();
        $user = User::find($attributes['owner_id']);

        $this->actingAs($user)
            ->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /**
     * @test
     */
    public function a_project_requires_a_title()
    {
        $attributes = factory(Project::class)->raw(['title' => '']);
        $user = User::find($attributes['owner_id']);

        $this->actingAs($user)
            ->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_requires_a_description()
    {
        $attributes = factory(Project::class)->raw(['description' => '']);

        $user = User::find($attributes['owner_id']);

        $this->actingAs($user)
            ->post('/projects', $attributes)->assertSessionHasErrors('description');
    }


    /**
     * @test
     */
    public function a_project_requires_an_owner()
    {
        $attributes = factory(Project::class)->raw();
        $user = User::find($attributes['owner_id']);

        $this->actingAs($user)
            ->post('/projects', $attributes)
            ->assertRedirect('/projects');
    }

    /**
     * @test
     */
    public function a_user_can_view_their_projects()
    {
        $this->withoutExceptionHandling();
        $this->be(factory(User::class)->create());
        $project = factory(Project::class)->create(['owner_id' => \auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
//        $this->withoutExceptionHandling();
        $this->be(factory(User::class)->create());
        $project = factory(Project::class)->create();

        $this->get($project->path())
            ->assertStatus(403);
    }
}
