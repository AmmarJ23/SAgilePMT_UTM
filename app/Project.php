<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['user_id','team_name', 'proj_name','proj_desc','start_date','end_date'];

    //public $foreignKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::created(function ($project) {
            // Create default statuses
            $project->statuses()->createMany([
                [
                    'title' => 'Backlog',
                    'slug' => 'backlog',
                    'order' => 1
                ],
                [
                    'title' => 'Up Next',
                    'slug' => 'up-next',
                    'order' => 2
                ],
                [
                    'title' => 'In Progress',
                    'slug' => 'in-progress',
                    'order' => 3
                ],
                [
                    'title' => 'Done',
                    'slug' => 'done',
                    'order' => 4
                ]
            ]);
        });
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class)->orderBy('order');
    }

    public function users()
    {
        // return $this->belongsToMany(User::class)->withPivot('attachment_access', 'project_access', 'sprint_access', 'userstory_access', 'forum_access', 'secfeature_access');
        return $this->belongsToMany(User::class)->withPivot('attachment_access', 'project_access');
    }

    public function userAccess()
    {
        return $this->hasMany(UserAccess::class);
    }
}


