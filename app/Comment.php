<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'user_id', 'forum_id', 'parent_id', // Add 'parent_comment_id' to fillable
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
