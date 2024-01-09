<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Burndownchart extends Model
{
    protected $fillable = ['task_name', 'description', 'story_points', 'due_date','end_date', 'proj_id'];

    public $primaryKey = 'id';

    public $foreignKey = ['task_id','sprint_id','status_id'];
}
