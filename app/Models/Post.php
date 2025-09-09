<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = ['title', "content", "user_id", "image"];
    protected $casts = [
        "created_at" => "datetime",
    ];

    protected function Title(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value), // accessor to get data
            // set: fn(string $value) => lcfirst($value), // mutator to save data
        );
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
public function comments()
{
    return $this->hasMany(Comments::class, 'post_id');
}
}
