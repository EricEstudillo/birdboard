<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function has_projects()
    {
//        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
//        factory(Project::class, 3)->create(['owner_id' => $user->id]);
//
//        $dbProjects = Project::where('owner_id', $user->id)->get();
//        $this->assertCount(3, count($dbProjects->toArray()));
    }
}
