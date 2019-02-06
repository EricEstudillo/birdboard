<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
  protected $fillable = ['body', 'project_id', 'completed'];
  
  protected $touches=['project'];
  
  public function path(): string
  {
    return \sprintf('/projects/%s/tasks/%s', $this->project->id, $this->id);
  }
  
  public function project(): BelongsTo
  {
    return $this->belongsTo(Project::class);
  }
}
