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

}
