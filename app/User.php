<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'username', 'country'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function pros()
    {
        return $this->hasMany(Project::class);
    }

    public function getCountryname()
    {
        return $this->country;
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot(
            'attachment_access',
            'project_access',
            'sprint_access',
            'userstory_access',
            'forum_access',
            'secfeature_access'
        );
    }

    // protected static function booted()
    // {
    //     static::created(function ($user) {
    //         // Create default statuses
    //         $user->statuses()->createMany([
    //             [
    //                 'title' => 'Backlog',
    //                 'slug' => 'backlog',
    //                 'order' => 1
    //             ],
    //             [
    //                 'title' => 'Up Next2',
    //                 'slug' => 'up-next2',
    //                 'order' => 2
    //             ],
    //             [
    //                 'title' => 'In Progress',
    //                 'slug' => 'in-progress',
    //                 'order' => 3
    //             ],
    //             [
    //                 'title' => 'Done',
    //                 'slug' => 'done',
    //                 'order' => 4
    //             ]
    //         ]);
    //     });
    // }



    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class)->orderBy('order');
    }

    public function teams()
    {
        return $this->hasManyThrough(Team::class, TeamMapping::class, 'username', 'team_id', 'username', 'team_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }
    public function teamMappings()
    {
        return $this->hasMany(TeamMapping::class, 'username', 'username');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    // Check if the user has any of the specified roles
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class, 'users_name', 'username');
    }

    public function userStories()
    {
        return $this->hasMany(UserStory::class, 'user_names', 'username');
    }

    public function forums()
    {
        return $this->hasMany(Forum::class, 'user_id', 'id');
    }

    public function securityFeatures()
    {
        return $this->hasMany(SecurityFeature::class, 'secfeature_id', 'id');
    }


    // FOR ACCESS LEVELS
    public function sprintsAccess()
    {
        return $this->belongsToMany(Sprint::class)->withPivot('sprint_access');
    }

    public function userStoriesAccess()
    {
        return $this->belongsToMany(UserStory::class)->withPivot('userstory_access');
    }

    public function forumsAccess()
    {
        return $this->belongsToMany(Forum::class)->withPivot('forum_access');
    }

    public function securityFeaturesAccess()
    {
        return $this->belongsToMany(SecurityFeature::class)->withPivot('secfeature_access');
    }

    public function isAdmin()
    {
        // Assuming you have a column named 'role' in your users table
        // where 'admin' represents the admin role
        return $this->user_role === 'Admin';
    }

    public function isUser()
    {
        // Assuming you have a column named 'role' in your users table
        // where 'user' represents the user role
        return $this->user_role === 'User';
    }

}
