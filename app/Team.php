<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['team_name','proj_name','team_names'];

    public $primaryKey = 'team_id';

    public function teamMappings()
    {
        return $this->hasMany(TeamMapping::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, TeamMapping::class, 'team_id', 'username', 'team_id', 'username');
    }
}
