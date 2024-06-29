<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    protected $table = 'sprint';

    protected $fillable = ['sprint_name','proj_name','sprint_desc','start_sprint','end_sprint','users_name'];

    public $primaryKey = 'sprint_id';


    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'users_name');
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('sprint_access');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function userAccess()
    {
        return $this->hasMany(UserAccess::class);
    }
}
