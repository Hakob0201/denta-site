<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ArticleHeadline extends Model {
    protected $hidden = ['created_at', 'updated_at'];

    protected static function boot() {
        parent::boot();

        static::addGlobalScope('locale', function (Builder $builder) {
            $builder->where('locale', app()->getLocale())
                ->where('datetime_at', '<', date('Y-m-d H:i:s'));
        });
    }

    /**
     * Get the contents for the article.
     */
    public function content() {
        return $this->hasOne('App\ArticleContent', 'article_id', 'article_id')->where('locale', app()->getLocale());
    }

    /**
     * Get the images for the article.
     */
    public function mainimage() {
        return $this->belongsToMany('App\Image', 'article_image', 'article_id', 'image_id', 'article_id')->withPivot('main')->where('main', 1);
    }

    public function getImageAttribute() {
        return $this->mainimage->first();
    }

    /**
     * Get the authors for the article.
     */
    public function authors() {
        return $this->belongsToMany('App\Author', 'article_author', 'article_id', 'author_id', 'article_id');
    }
}
