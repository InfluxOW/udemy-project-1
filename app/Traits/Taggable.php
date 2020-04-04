<?php

namespace App\Traits;

use App\Tag;

trait Taggable
{
    protected static function bootTaggable()
    {
        static::created(function ($model) {
            $model->tags()->sync(static::findTags($model->content));
        });

        static::updated(function ($model) {
            $model->tags()->sync(static::findTags($model->content));
        });
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable')->withTimestamps();
    }

    private static function findTags($content)
    {
        preg_match_all('/@([^@]+)@/m', $content, $tags);

        return Tag::whereIn('name', $tags[1] ?? [])->get();
    }

}
