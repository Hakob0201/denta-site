<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    protected $table  = 'articles';
    protected $hidden = ['created_at', 'updated_at'];

    protected static function boot() {
        parent::boot();

        $preview = \Request::has('preview');

        static::addGlobalScope('contents', function (Builder $builder) use ($preview) {
            $builder->whereHas('contents', function ($q) use ($preview) {
                if (!$preview) {
                    $q->where('onoff', 1)
                        ->where('datetime_at', '<', date('Y-m-d H:i:s'));
                }
            });
        });

        if (!$preview) {
            static::addGlobalScope('onoff', function (Builder $builder) {
                $builder->where('articles.onoff', 1);
            });
        }

    }

    /**
     * Get the contents for the article.
     */
    public function contents() {
        return $this->hasOne('App\ArticleContent')->where('locale', app()->getLocale());
    }

    /**
     * Get the translations for the article.
     */
    public function otherCont($locale) {
        return $this->hasOne('App\ArticleContent')->where('locale', $locale)->where('onoff', 1);
    }

    /**
     * Get the images for the article.
     */
    public function images() {
        return $this->belongsToMany('App\Image')->withPivot(['slider', 'show_title'])->orderBy('ordering', 'asc');
    }

    /**
     * Get the main image for the article.
     */
    public function mainimage() {
        return $this->belongsToMany('App\Image')->withPivot('main')->where('main', 1);
    }

    public function getImageAttribute() {
        return $this->mainimage->first();
    }

    /**
     * Get the views for the article.
     */
    public function views() {
        return $this->hasOne('App\ArticleView')->where('locale', app()->getLocale());
    }

    /**
     * Get the categories for the article.
     */
    public function categories() {
        return $this->belongsToMany('App\Category');
    }

    /**
     * Get the tags for the article.
     */
    public function tags() {
        return $this->belongsToMany('App\Tag')->where('locale', app()->getLocale());
    }

    /**
     * Get the authors for the article.
     */
    public function authors() {
        return $this->belongsToMany('App\Author'); //->orderBy('id', 'desc');
    }

    /**
     * Get headlines for the article.
     */
    public function headlines($locale = null) {
        return $this->hasMany('App\ArticleHeadline');
    }
}
