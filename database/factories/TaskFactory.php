<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
  return [
    'body' => $faker->sentence(4),
    'project_id' => factory(\App\Project::class)->create(),
  ];
});
