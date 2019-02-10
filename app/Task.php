<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
  protected $fillable = ['body', 'project_id', 'completed'];
  
  protected $touches = ['project'];
  protected $casts = ['completed' => 'boolean'];
  
  
  public function project(): BelongsTo
  {
    return $this->belongsTo(Project::class);
  }
  
  
  public function activity(): MorphMany
  {
    return $this->morphMany(Activity::class, 'subject')->latest();
  }
  
  public function path(): string
  {
    return \sprintf('/projects/%s/tasks/%s', $this->project->id, $this->id);
  }
  
  public function recordActivity(string $description): void
  {
    $this->activity()->create([
      'description' => $description,
      'project_id' => $this->project->id,
    ]);
  }
  
  public function complete(): void
  {
    $this->update(['completed' => true]);
    $this->recordActivity('completed_task');
  }
  
  public function incomplete(): void
  {
    $this->update(['completed' => false]);
    $this->recordActivity('uncompleted_task');
  }
}
