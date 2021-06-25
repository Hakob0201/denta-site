<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'article_id', 'locale', 'views',
    ];
}
