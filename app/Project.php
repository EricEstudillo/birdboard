<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  protected $fillable = ['title', 'description', 'notes', 'owner_id'];
  
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
    return $this->hasMany(Activity::class);
  }
  
  /**
   * @param string $description
   */
  public function recordActivity(string $description): void
  {
    $this->activity()->create(compact('description'));
  }
}
