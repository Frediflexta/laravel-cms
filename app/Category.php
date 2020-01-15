<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * creates the relationship between posts and category.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
