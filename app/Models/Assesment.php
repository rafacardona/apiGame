<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assesment extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['points'];

    /**
     * @return BelongsTo
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     *
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

}
