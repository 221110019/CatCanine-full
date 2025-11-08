<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'caption',
        'picture',
        'likes_count',
        'reports_count',
    ];

    protected $casts = [
        'likes_count' => 'integer',
        'reports_count' => 'integer',
    ];

    protected $with = ['user', 'comments'];

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
    protected static function booted()
    {
        static::deleting(function ($post) {
            if ($post->picture) {
                Storage::disk('public')->delete($post->picture);
            }
        });
    }
}
