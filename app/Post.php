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

    /**
     * pivot table.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function hasTags($tagId)
    {
        return in_array($tagId, $this->tags->modelKeys());
    }
}
