<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMapping extends Model
{
    protected $table = 'teammappings';

    protected $fillable = ['role_id','username','team_id'];

    public $primaryKey = 'teammapping_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'team_id');
    }


    public function showAccessControlList()
    {
        $teams = TeamMapping::select('team_id', 'team_name')->distinct()->get();
        return view('content/pages/access-control-list', compact('teams'));
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->attachments = $model->attachments ?? true;
            $model->projects = $model->projects ?? true;
            $model->sprints = $model->sprints ?? true;
            $model->user_stories = $model->user_stories ?? true;
            $model->forum = $model->forum ?? true;
            $model->security_feature = $model->security_feature ?? true;
        });

        static::updating(function ($model) {
            $model->attachments = $model->attachments ?? true;
            $model->projects = $model->projects ?? true;
            $model->sprints = $model->sprints ?? true;
            $model->user_stories = $model->user_stories ?? true;
            $model->forum = $model->forum ?? true;
            $model->security_feature = $model->security_feature ?? true;
        });
    }

}
