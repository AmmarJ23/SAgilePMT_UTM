<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bugscore extends Model
{
    // The table associated with the model.
    protected $table = 'bugscore';

    // The attributes that are mass assignable.
    protected $fillable = [
        'project_id',
        'severity_weight',
        'status_weight',
        'due_weight',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'severity_weight' => 'decimal:2',
        'status_weight' => 'decimal:2',
        'due_weight' => 'decimal:2',
    ];
}
