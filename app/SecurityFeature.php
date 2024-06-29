<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityFeature extends Model
{
    protected $fillable = ['secfeature_name', 'secfeature_desc'];

    public $primaryKey = 'secfeature_id';

    public function userStories()
    {
        return $this->belongsToMany(UserStory::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('secfeature_access');
    }
}
