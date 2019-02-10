<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = ['title', 'description', 'notes', 'owner_id'];
  public $old = [];
  
  public function path(): string
  {
    return '/projects/' . $this->id;
  }
  
  public function owner()
  {
    return $this->belongsTo(User::class, 'owner_id');
  }
  
  public function tasks()
  {
    return $this->hasMany(Task::class);
  }
  
  public function addTask(string $body): Task
  {
    return $this->tasks()->create(['body' => $body]);
  }
  
  public function activity()
  {
    return $this->hasMany(Activity::class)->latest();
  }
  
  /**
   * @param string $description
   */
  public function recordActivity(string $description): void
  {
    $this->activity()->create([
      'description' => $description,
      'changes' => $this->getActivityChanges($description),
    ]);
  }
  
  public function getActivityChanges(string $description): ?array
  {
    if ($description === 'updated') {
      return [
        'before' => \array_except(\array_diff($this->old, $this->getAttributes()),'updated_at'),
        'after' => \array_except($this->getChanges(),'updated_at'),
      ];
    }
    return null;
    
  }
}
