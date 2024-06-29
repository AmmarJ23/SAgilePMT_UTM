<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    protected $fillable = ['user_story','means','perfeature_id','secfeature_id','user_names','prio_story','status_id'];

    public $primaryKey = 'u_id';

    public $foreignKey = ['sprint_id', 'proj_id'];

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function securityFeatures()
    {
        return $this->belongsToMany(SecurityFeature::class, 'security_feature_user_story', 'user_story_id', 'security_feature_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_names', 'username');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('userstory_access');
    }

    public function userAccess()
    {
        return $this->hasMany(UserAccess::class);
    }
}
