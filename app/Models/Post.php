<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
<<<<<<< Updated upstream
use Illuminate\Support\Facades\Storage;
=======
>>>>>>> Stashed changes

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'caption',
        'picture',
        'type',
        'likes_count',
        'reports_count',
        'status',
    ];


    protected $casts = [
        'likes_count' => 'integer',
        'reports_count' => 'integer',
    ];

    protected $with = ['user', 'comments', 'userReports'];


    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reporters()
    {
        return $this->hasMany(PostReport::class);
    }
    protected $appends = ['canDelete'];

    public function getCanDeleteAttribute()
    {
        if (!Auth::check()) return false;

        return Auth::id() === $this->user_id;
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function userReports()
    {
        return $this->hasMany(UserReport::class, 'post_id');
    }
}
