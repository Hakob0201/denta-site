<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * Change tag name to object
     */
    public function getTagNameAttribute($tag_name) {
        return json_decode($tag_name)->{app()->getLocale()};
    }
}
