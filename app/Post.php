<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    /**
     * delete post image from storage.
     */
    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    /**
     * creates a relationship between category and posts.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
