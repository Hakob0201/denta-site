<?php

namespace App\Http\Controllers;

use App\Article;
use App\ArticleHeadline;
use DB;
use Illuminate\Support\Facades\Cache;
use Redirect;
use MetaTag;

class ArticleController extends Controller
{

    private $limit = 19;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index($layout, $category = null, $date = null)
    {
        $view = substr($layout, 0, -1);
        $page = request()->get('page') ? request()->get('page') : 1;

        if (!is_null($category) && is_null($cat = app()->categories->firstWhere('category_key', $category))) {
            return abort(404);
        }

        $articles = Cache::remember('article_cats_' . ($category !== null ? $category . '_' : '') . $page . '_' . ($layout !== null ? $layout . '_' : '') . ($date !== null ? $date[0] . '_' . $date[1] . '_' . $date[2] . '_' : '') . '_' . app()->locale, 2 * 60, function () use ($category, $view, $date) {

            $articles = Article::with('contents')->with('tags')->with('mainimage');

            if ($view != 'article' && is_null($category)) {
                $articles->where('layout_id', app()->layouts['article']['key'][$view]);
            }

            $articles->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) use ($date) {
                $q->on('articles.id', '=', 'article_contents.article_id')
                    ->where('article_contents.locale', app()->locale);

                if (!is_null($date)) {
                    $q->where('article_contents.date_at', $date[0] . '-' . $date[1] . '-' . $date[2]);
                }

            })->select('articles.*')
                ->orderBy('article_contents.datetime_at', 'desc');

            if (!is_null($category)) {
                $articles->whereHas('categories', function ($q) use ($category) {
                    $q->whereHas('parent', function ($q) use ($category) {
                        $q->where('category_key', $category);
                    })->orWhere('category_key', $category);
                });
            }

            $articles = $articles->simplePaginate($this->limit);

            return $articles;
        });

        if (!is_null($category)) {
            MetaTag::setTags([
                'title' => $cat->category_name . ' - ' . __('main.meta.title'),
                'description' => $cat->category_name . ' - ' . __('main.meta.description'),
            ]);

            $view = app()->layouts['category'][$cat->layout_id];
        } else {
            MetaTag::setTags([
                'title' => __('main.articles') . ' - ' . __('main.meta.title'),
                'description' => __('main.articles') . ' - ' . __('main.meta.description'),
            ]);

            $category = 'all-articles';
        }

        if (request()->ajax()) {
            if ($articles->count() == 0) {
                return abort(404);
            }
            return view('articles.list.' . $view, compact('articles', 'category', 'view', 'page'))->render();
        }

        return view('articles.list.master', compact('articles', 'category', 'view', 'page'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article, $amp = null)
    {
        if (!$article || !$article->contents) {
            return redirect()->intended(app()->locale);
        }

        MetaTag::setTags([
            'title' => $article->contents->title,
            'description' => $article->contents->anons,
            'og_title' => $article->contents->title,
            'og_description' => $article->contents->anons,
            'og_type' => 'article',
        ]);

        if ($article->image) {
            $imgPrefix = (stripos($article->image->name, '.gif')) ? '' : 'l-';

            MetaTag::setTags([
                'og_image' => url('/') . '/storage' . $article->image->url . $imgPrefix . $article->image->name,
            ]);
        }

        $videoSlug = '';
        if ($article->contents->video) {
            $videoSlug = ' ' . __('main.videoslug');
        }

        if (!$article->views) {
            $article->views()->create([
                'views' => 1,
                'locale' => app()->locale,
            ]);
        } else {
            $article->views->increment('views');
        }
        if ($amp && $article['contents']['video'] !== null) {
            $article['contents']['video'] = $this->iframeVideo($article['contents']['video']);
        }
        if ($amp) {
            $article['contents']['text'] = $this->iframeVideo($article['contents']['text']);
            $article['contents']['text'] = $this->textImg($article['contents']['text']);
            $article['contents']['text'] = $this->textAudio($article['contents']['text']);

        }

        return view('articles.item.' . app()->layouts['article'][$article->layout_id], compact('article', 'videoSlug', 'amp'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param $content
     * @return string
     */
    public function textImg($content): string
    {
        preg_match_all('#<img(?:.*?)>#is', $content, $textImages);
        if ($textImages) {
            foreach ($textImages[0] as $textImg) {
                $content = str_replace($textImg, $this->preg_match_images($textImg), $content);
            }
        }
        return $content;
    }

    public function textAudio($content): string
    {
        preg_match_all('#<audio(?:.*?)></audio>#is', $content, $textAudios);
        if ($textAudios) {
            foreach ($textAudios[0] as $textAudio) {
                $content = str_replace($textAudio, $this->preg_match_audios($textAudio), $content);
            }
        }
        return $content;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @param $preg_match_content
     * @return string
     */
    public function preg_match_images($preg_match_content): string
    {
        preg_match('#<img(.*?)/>#is', $preg_match_content, $content);
        return '<amp-img ' . $content[1] . '></amp-img>';
    }

    public function preg_match_audios($preg_match_content): string
    {

        preg_match('#<audio(.*?)></audio>#is', $preg_match_content, $content);
        return '<amp-audio ' . $content[1] . ' width="300" height="300"></amp-audio>';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $content
     * @return string
     */
    public function iframeVideo($content): string
    {
        preg_match_all('/<iframe.*?>/', $content, $iframeVideo);

        if ($iframeVideo != null) {

            foreach ($iframeVideo[0] as $iframe) {
                $content = str_replace($iframe, $this->preg_match_content($iframe), $content);
            }

        }
        return $content;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param $preg_match_content
     * @return string
     */
    public function preg_match_content($preg_match_content): string
    {
        $src = $this->preg_match_iframe_src($preg_match_content);
        $width = $this->preg_match_iframe_width($preg_match_content);
        $height = $this->preg_match_iframe_height($preg_match_content);

        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $preg_match_content, $youtube)) {
            return   '<amp-youtube   data-videoid="' . $youtube[1] . '"   layout="responsive"     ' . $width . '  ' . $height . '  ></amp-youtube>';
        }

        if (preg_match('%(?:facebook(?:-nocookie)?\.com/(?:[^/]+/[^/]+))%i', $preg_match_content, $facebook)) {
            preg_match('/Fvideos%2F([^"]+)%/', $facebook[0], $href);
            return '<amp-facebook   data-href="https://www.facebook.com/zuck/videos/' . $href[1] . '/"   layout="responsive"  data-embed-as="video"    ' . $width . '  ' . $height . '  ></amp-facebook>';
        }

        if (preg_match('#https://player.vimeo.com/video/((?:[0-9]+))#', $preg_match_content, $vimeo)) {
            return  '<amp-vimeo data-videoid="' . $vimeo[1] . '" layout="responsive" ' . $width . '  ' . $height . '></amp-vimeo>';
        }

        return "<amp-iframe $src  sandbox=" . '"allow-scripts allow-same-origin"' . " layout=" . '"responsive"' . "   $width $height></amp-iframe>";
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param $content
     * @return string
     */
    public function preg_match_iframe_src($content): string
    {
        preg_match('/src="([^"]+)"/', $content, $src);
        return $src[0];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $content
     * @return string
     */
    public function preg_match_iframe_height($content): string
    {
        preg_match('/height="((?:[0-9]+))/', $content, $height);
        return $height[0] . '"';
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param $content
     * @return string
     */
    public function preg_match_iframe_width($content): string
    {
        preg_match('/width="((?:[0-9]+))/', $content, $width);
        return $width[0] . '"';
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function ampShow(Article $article)
    {
        return $this->show($article, true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articleFeed()
    {
        $page = request()->get('page');

        $articles = Cache::remember('article_feed_articles_' . ($page !== null ? $page . '_' : '') . (request()->ajax() ? 'ajax' . '_' : '') . app()->locale, 2 * 59, function () use ($page) {
            $articles = Article::with('contents')->with('mainimage')->where('feed', 1)
                ->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) {
                    $q->on('articles.id', '=', 'article_contents.article_id')
                        ->where('article_contents.locale', app()->locale);
                });

            $articles->select('articles.*')
                ->orderBy('article_contents.datetime_at', 'desc');

            $articles = $articles->simplePaginate($this->limit);

            return $articles;
        });

        if (request()->ajax()) {
            if ($articles->count() == 0) {
                return abort(404);
            }

            if (is_null($page)) {
                return view('includes.articles.feed', ['items' => $articles->all(), 'page' => $page])->render();
            }

            return view('includes.articles.feed-items', ['items' => $articles->all(), 'page' => $page])->render();
        }

        return $articles;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function articleMostRead()
    {

        $articles = Cache::remember('article_most_read_' . app()->locale, 5 * 61, function () {

            $articles = Article::with('contents')->with('views')->where('feed', 1);

            $articles->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) {
                $q->on('articles.id', '=', 'article_contents.article_id')
                    ->where('article_contents.locale', app()->locale)
                    ->whereBetween('datetime_at', [date('Y-m-d H:i:s', strtotime('-3 week')), date('Y-m-d H:i:s')]);
            });

            $articles->join(DB::raw('`article_views` FORCE INDEX FOR JOIN(article_views_views_index)'), function ($q) {
                $q->on('articles.id', '=', 'article_views.article_id')
                    ->where('article_views.locale', app()->locale);
            })
                ->select('articles.*')
                ->orderBy('article_views.views', 'desc');

            $articles = $articles->take(6)->get(['title', 'articles.id', 'article_views.views', 'article_contents.datetime_at']);

            return $articles;
        });

        return $articles;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Article $article
     * @return \Illuminate\Http\Response
     */
    public function articleHeadlines($category = null)
    {
        $cachekey = 'top_articles_' . ($category ? $category . '_' : '') . app()->locale;

        $articles = Cache::remember($cachekey, 2 * 62, function () use ($category) {

            $articles = ArticleHeadline::with('content')->with('mainimage'); //->with('authors'); //

            if (!is_null($category)) {
                $articles->where('category_key', $category);
            }

            $articles->orderBy('category_key')->orderBy('ordering')->orderBy('id', 'desc');
            $articles = $articles->take(100)->get();

            return $articles->groupBy('category_key');
        });

        return $articles;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param bool $ct
     * @return false|string
     */
    public function search($ct = false)
    {


        $page = request()->get('page') ?: 0;
        $query = request()->get('q');

        if ($ct) {
            return mb_strtolower(json_encode([
                'categories' => app()->categories->map->only(['id', 'category_key', 'category_name']),
                'tags' => app()->tags
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        }

        if (mb_strlen($query) < 3) {
            return redirect('/');
        }

        if (!request()->ajax()) {
            $articles = Article::with('contents')->with('mainimage');
        } else {
            $articles = Article::with('contents:id,article_id,title,anons,datetime_at');
        }

        $articles->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) use ($query) {
            $q->on('articles.id', '=', 'article_contents.article_id')
                ->where('article_contents.locale', app()->locale);
        })->select('articles.*')
            ->orderBy('article_contents.datetime_at', 'desc');

        $articles->whereHas('contents', function ($q) use ($query) {
            $q->where('article_contents.title', 'like', '%' . $query . '%')
                ->orWhere('article_contents.anons', 'like', '%' . $query . '%');
        });

        $articles = $articles->simplePaginate($this->limit);

        if (request()->ajax()) {
            if ($articles->count() == 0 && !request()->get('__amp_source_origin')) {
                return abort(404);
            }

            if ($page != 0) {
                return view('articles.list.article', compact('articles', 'page'));
            }

            return $articles;
        } else {
            MetaTag::setTags([
                'title' => $query . ' - ' . __('main.meta.title'),
                'description' => $query . ' - ' . __('main.meta.description'),
            ]);
        }

        $view = 'search-result';

        return view('articles.list.lite', compact('articles', 'page', 'view'));
    }

    function validateDate($date, $format = 'Y/m/d')
    {
        $d = \DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive($layout, $year, $month, $day, $var = null)
    {
        if (!is_null($var)) {
            $temp = $year;
            $year = $month;
            $month = $day;
            $day = $var;
            $var = $temp;
        }

        if (!$this->validateDate($year . '/' . $month . '/' . $day)) {
            return redirect(app()->locale . '/' . $layout . '/' . ($var ? $var . '/' : '') . date('Y/m/d'));
        }

        return $this->index($layout, $var, [$year, $month, $day]);
    }

    public function byTag($slug)
    {
        $page = request()->get('page') ?: 0;

        if (is_null($tag = app()->tags->firstWhere('tag_slug', $slug))) {
            abort(404);
        }

        $articles = Cache::remember('articles_bytag_' . $slug, 10 * 60, function () use ($slug) {
            $articles = Article::with('contents')->with('tags')->with('mainimage');
            $articles->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) {
                $q->on('articles.id', '=', 'article_contents.article_id')
                    ->where('article_contents.locale', app()->locale);

            })->select('articles.*')
                ->orderBy('article_contents.datetime_at', 'desc');

            $articles->whereHas('tags', function ($q) use ($slug) {
                $q->where('tag_slug', $slug);
            });

            $articles = $articles->simplePaginate($this->limit);

            return $articles;
        });

        MetaTag::setTags([
            'title' => $tag->tag_name . ' - ' . __('main.meta.title'),
            'description' => $tag->tag_name . ' - ' . __('main.meta.description'),
        ]);

        $view = 'tag-result';

        return view('articles.list.lite', compact('articles', 'view', 'tag', 'page'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rss($category = null)
    {

        $articles = Cache::remember('article_cats_rss_' . ($category !== null ? $category . '_' : '') . app()->locale, 5 * 60, function () use ($category) {

            $articles = Article::with('contents')->with('mainimage'); //->where('feed', 1); //->with('authors')

            $articles->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) {
                $q->on('articles.id', '=', 'article_contents.article_id')
                    ->where('article_contents.locale', app()->locale);

            })->select('articles.*')
                ->orderBy('article_contents.datetime_at', 'desc');

            if (!is_null($category)) {
                $articles->whereHas('categories', function ($q) use ($category) {
                    $q->whereHas('parent', function ($q) use ($category) {
                        $q->where('category_key', $category);
                    })->orWhere('category_key', $category);
                });
            }

            $articles = $articles->simplePaginate(50);

            return $articles;
        });

        if ($articles->count() == 0) {
            abort(404);
        }

        $content = view('articles.rss', compact('articles', 'category'));

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rssGoogle($category = null)
    {

        $articles = Cache::remember('article_cats_rss_google_' . ($category !== null ? $category . '_' : '') . app()->locale, 5 * 60, function () use ($category) {

            $articles = Article::with('contents')->with('mainimage')->where('feed', 1); //->with('authors')

            $articles->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) {
                $q->on('articles.id', '=', 'article_contents.article_id')
                    ->where('article_contents.locale', app()->locale);

            })->select('articles.*')
                ->orderBy('article_contents.datetime_at', 'desc');

            if (!is_null($category)) {
                $articles->whereHas('categories', function ($q) use ($category) {
                    $q->whereHas('parent', function ($q) use ($category) {
                        $q->where('category_key', $category);
                    })->orWhere('category_key', $category);
                });
            }

            $articles = $articles->simplePaginate(50);

            return $articles;
        });

        if ($articles->count() == 0) {
            abort(404);
        }

        $content = view('articles.rss-google', compact('articles', 'category'));

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rssYandex($category = null)
    {

        $articles = Cache::remember('article_cats_rss_yandex_' . ($category !== null ? $category . '_' : '') . app()->locale, 5 * 60, function () use ($category) {

            $articles = Article::with('contents')->with('mainimage')->where('feed', 1); //->with('authors')

            $articles->join(DB::raw('`article_contents` FORCE INDEX FOR JOIN(article_contents_datetime_at_index)'), function ($q) {
                $q->on('articles.id', '=', 'article_contents.article_id')
                    ->where('article_contents.locale', app()->locale);

            })->select('articles.*')
                ->orderBy('article_contents.datetime_at', 'desc');

            if (!is_null($category)) {
                $articles->whereHas('categories', function ($q) use ($category) {
                    $q->whereHas('parent', function ($q) use ($category) {
                        $q->where('category_key', $category);
                    })->orWhere('category_key', $category);
                });
            }

            $articles = $articles->simplePaginate(50);

            return $articles;
        });

        if ($articles->count() == 0) {
            abort(404);
        }

        $content = view('articles.rss-yandex', compact('articles', 'category'));

        return response($content, 200)->header('Content-Type', 'text/xml');
    }

}
