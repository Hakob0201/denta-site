<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Get the parent for the category.
     */
    public function parent()
    {
        return $this->belongsTo('App\Category', 'category_id')->without('childs');
    }

    /**
     * Get the childs for the category.
     */
    public function childs()
    {
        return $this->hasMany('App\Category')->without('parent');
    }

    /**
     * Get the articles for the category.
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * Change category name to object
     */
    public function getCategoryNameAttribute($category_name) {
        return json_decode($category_name)->{app()->getLocale()};
    }
}
