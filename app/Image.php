<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function getTitleAttribute($title) {
        return json_decode($title)->{app()->getLocale()};
    }
}
