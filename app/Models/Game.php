<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'autor',
        'genre',
        'img',
        'release_date',
        'description'
    ];

    /**
     * @return HasMany
     * Get the comments for the game
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return HasMany
     * Get the assesments for the game
     */
    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
