<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    /**
     * pivot relationship with the Post model.
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
