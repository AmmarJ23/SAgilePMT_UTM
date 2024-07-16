<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table = 'forums';

    protected $fillable = [
        'title', 'content', 'category', 'image_urls', 'user_id','project_id', 'assigned_users',
    ];
    
    
    // Define relationships if needed, e.g., a forum belongs to a user.
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming you have a 'User' model.
    }

    // Add other methods or relationships as required for your application.
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favorites()
    {
        return $this->hasMany(ForumFavorite::class);
    }

        // Forum.php model
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

}
