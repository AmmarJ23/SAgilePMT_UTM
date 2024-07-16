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

    // Relationship to parent comment (one-to-many self-referential)
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_id')->withDefault();
    }

    // Relationship to replies (one-to-many self-referential)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
