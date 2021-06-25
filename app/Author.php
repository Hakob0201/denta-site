<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * Get the articles for the author.
     */
    public function articles()
    {
        return $this->belongsToMany('App\Article');
    }

    /**
     * Change name to object
     */
    public function getFullnameAttribute($author) {
        return json_decode($author)->{app()->getLocale()};
    }

    /**
     * Change name to object
     */
    public function getPositionAttribute($author) {
        return json_decode($author)->{app()->getLocale()};
    }
}
