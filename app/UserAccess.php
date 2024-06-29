<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $table = 'project_user';

    protected $fillable = ['attachment_access', 'project_access', 'sprint_access', 'userstory_access', 'forum_access', 'secfeature_access'];

    // Define additional columns and relationships as needed
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function userStory()
    {
        return $this->belongsTo(UserStory::class);
    }

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function securityFeature()
    {
        return $this->belongsTo(SecurityFeature::class);
    }

}
