<?php

/**
 * return set of categories
 * @return array
 */
function getCategories() {
    if (!Schema::hasTable('categories')) {
        return false;
    }

    $categories = Cache::remember('categories', 60, function () {
        return App\Category::where('onoff', 1)
            ->with ('childs')
            ->orderBy('ordering', 'asc')
            ->get(['id', 'layout_id', 'category_id', 'category_key', 'category_name', 'visible']);
    });

    return $categories;
}

/**
 * return set of authors
 * @return array
 */
function getAuthors() {
    if (!Schema::hasTable('authors')) {
        return false;
    }

    $authors = App\Author::where('onoff', 1)
        ->orderBy('ordering', 'asc');

    return $authors;
}

function getForecast() {

    $forecasts = Cache::remember('forecast_' . app()->locale, 30, function () {
        if (!Schema::hasTable('forecasts')) {
            return false;
        }

        return DB::select("SELECT * FROM `forecasts`");
    });

    return $forecasts;
}

function getCurrency() {
    if (!Schema::hasTable('currencies')) {
        return [];
    }

    $currencies = Cache::remember('currency', 60, function () {
//        return App\Currency::whereIn('currency', ['USD', 'GBP', 'EUR', 'RUB'])->latest()->take(6)->get();
        return App\Currency::latest()->take(6)->get();
    });

    return $currencies;
}

function getLayouts() {
    if (!Schema::hasTable('layouts')) {
        return false;
    }

    $layouts = Cache::remember('layouts', 60, function () {
        return DB::select("SELECT * FROM `layouts` WHERE `onoff` = 1");
    });

    $arr = [];

    foreach ($layouts as $layout) {
        $arr[$layout->layout_type][$layout->id] = $layout->layout_key;
        $arr[$layout->layout_type]['key'][$layout->layout_key] = $layout->id;
    }

    return collect($arr);
}

/**
 * return set of tags
 * @return array
 */
function getTags() {
    if (!Schema::hasTable('tags')) {
        return false;
    }

    $tags = Cache::remember('tags', 60, function () {
        return App\Tag::where('onoff', 1)->get(['id', 'tag_slug', 'tag_name']);
    });

    return $tags;
}

/*
 *	get popular Tag IDs
 */
function popularTags() {
    if (!Schema::hasTable('article_tag')) {
        return false;
    }

    $tags = Cache::remember('popular_tags_' . app()->locale, 300, function () {

        return DB::select("SELECT `tag_id`, count(`tag_id`) as `tc`, `tags`.* FROM `article_tag`
					LEFT JOIN `tags` ON `tags`.`id` = `article_tag`.`tag_id`
					WHERE `article_tag`.`locale` = '" . app()->getLocale() . "'
					GROUP BY `tag_id`
					ORDER BY `tc` DESC
					LIMIT 10");

    });

    return $tags;
}

/**
 * return next Article ID
 * @return array
 */
function getNextArticleId($article) {

    $tags = $article->tags->pluck('id')->toArray();

    $listOfIds = DB::table('article_tag')
        ->where('locale', app()->locale)
        ->whereIn('tag_id', $tags)
        ->where('article_id', '<', $article->id)
        ->orderBy('article_id', 'desc')
        ->take(10)
        ->get(['article_id'])->pluck('article_id');

    return $listOfIds;

}

/**
 * formated datetime for moment.js
 */
function dateF($datetime) {
    return date('c', strtotime($datetime));
}

/**
 * Json value
 */
function getJsonValue($json, $key = 'en') {
    if (is_array($json)) {
        return $json[$key];
    }

    $array = json_decode($json, true);

    return @$array[$key];
}

/*
 *   cuts given string
 */
function cutText($text, $maxs = 70) {
    $space = " ";

    $endpos = @strpos($text, $space, $maxs);

    if ($endpos == '') {
        $rtext = $text;
    } else {
        $rtext = @substr($text, 0, $endpos) . "...";
    }

    return $rtext;
}

/**
 * @return [type]
 */
function articleBody($article) {
    $text = $article->contents->text;

    if (preg_match_all("/<slider data-id=\"(.*)\">(.*)<\/slider>/", $text, $matches) > 0) {
        $out = [];
        foreach ($matches[1] as $match) {
            $slider_id = intval($match);
            $photostr  = view('includes.articles.slider', ['article' => $article, 'slider_id' => $slider_id])->render();
            $out[]     = (string) $photostr;
        }
        $text = str_replace($matches[0], $out, $text);
    }

    return $text;
}

/**
 * return path by given ID
 * @return array
 */
function idToPath($id, $array = false) {
    $id = intval($id);

    if ($array) {
        $path = [];
    } else {
        $path = '';
    }

    $lenght = ceil(strlen($id) / 2) * 2;
    if (strlen($id) < $lenght) {
        $id = '0' . $id;
    }
    $lenght = $lenght / 2;

    for ($i = 1; $i <= $lenght; $i++) {
        $dir = substr($id, ($i - 1) * 2, 2);

        if ($array) {
            $path[] = $dir;
        } else {
            $path .= $dir . '/';
        }
    }

    return $path;
}

/**
 * return current user Ip address
 */

function user_ip()	{
    return (isset($_SERVER['HTTP_X_FORWARDED_FOR']))? @$_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
}

/*
 *
 */
function getBanners() {

    $zones = DB::select('select `id` as `zone_id` FROM banners_zones WHERE onoff = 1');

    $bannerstmp = DB::select('select *, (views/rotation) as `weight`
                            FROM banners
                            WHERE onoff = 1 AND ((start_at IS NULL AND end_at IS NULL) OR (start_at<= NOW() AND end_at >=NOW()))
                            ORDER BY `weight` DESC');

    $banners = [];
    foreach ($zones as $z) {
        foreach ($bannerstmp as $bannerstmp_item) {
            if (($bannerstmp_item->zone_id == $z->zone_id) && !is_array(@$banners[$z->zone_id])) {
                $banners[$z->zone_id] = $bannerstmp_item;
            }

        }
    }

    //dd($banners);

    return $banners;
}

/*
 *
 */
function banner($zone_id = 0, $banners, $class = '') {

    $str = "";
    $a   = "";
    $a_  = "";

    if (!isset($banners[$zone_id])) {
        return;
    }

    $BANNER = "";

    if ($banners[$zone_id]->link != '') {
        $a  = "<a href='{$banners[$zone_id]->link}' class='links'  target='_blank'>";
        $a_ = "</a>";
    }

    $clickdiv  = "<div data-id=\"{$banners[$zone_id]->zone_id}\" class=\"bncont {$class}\">";
    $clickdiv_ = "</div>";

    if (isMobile()) {
        //dump($banners[$zone_id]);
        if ($banners[$zone_id]->filemobile != '' && file_exists(public_path() . "/static/azd/" . $banners[$zone_id]->id . "/" . $banners[$zone_id]->filemobile)) {
            $BANNER = "<img src=\"/static/azd/" . $banners[$zone_id]->id . "/" . $banners[$zone_id]->filemobile . "\" alt=\"\" width=\"100%\" >";
        } elseif ($banners[$zone_id]->codemobile != '') {
            $BANNER = $banners[$zone_id]->codemobile;
        }

        if ($banners[$zone_id]->linkmobile != '') {
            $a  = "<a href='{$banners[$zone_id]->linkmobile}' class='links'  target='_blank'>";
            $a_ = "</a>";
        }
    } else {
        if ($banners[$zone_id]->type == 'html5') {
            $BANNER = "<iframe class=\"ad-iframe\" src=\"/static/azd/" . $banners[$zone_id]->id . "/index.html\" width=\"" . $banners[$zone_id]->width . "\" height=\"" . $banners[$zone_id]->height . "\" frameborder=\"0\"></iframe>";
        } elseif ($banners[$zone_id]->type == 'code') {
            $BANNER = $banners[$zone_id]->code;
        } elseif ($banners[$zone_id]->type == 'image') {
            if (file_exists(public_path() . "/static/azd/" . $banners[$zone_id]->id . "/" . $banners[$zone_id]->file)) {
                $BANNER = "<img src=\"/static/azd/" . $banners[$zone_id]->id . "/" . $banners[$zone_id]->file . "\" alt=\"\">";
            } else {
                $BANNER = "File not found";
            }

            // $BANNER = $banners[$zone_id]->file;
        } else {
            $BANNER = 'def';
        }
    }

    if ($BANNER == '') {
        return;
    }

    $str .= ($banners[$zone_id]->link != '' or $banners[$zone_id]->linkmobile != '') ? $clickdiv . $a . $BANNER . $a_ . $clickdiv_ : $clickdiv . $BANNER . $clickdiv_;

    if ($banners[$zone_id]->zone_id > 0) {
        $zones = DB::update("UPDATE `banners`
        SET `views` = " . ($banners[$zone_id]->views + 1) . ",
            `views_total` = " . ($banners[$zone_id]->views_total + 1) . "
            WHERE id = ?", [$banners[$zone_id]->id]);
    }

    return '<div class="azd-fullwidth">' . $str . '</div>';
}

/*
 *   Mobile detect
 */
function isMobile() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
        return true;
    } else {
        return false;
    }

}

function bannerSimple($zone) {
    $ads = Cache::remember('ads_all_zone_' . $zone, 60, function () use ($zone) {
        return App\Banner::where('zone_id', $zone)->get();
    });
    $sum = Cache::remember('ads_sum_zone_' . $zone, 60, function () use ($zone) {
        return App\Banner::where('zone_id', $zone)->sum('rotation');
    });

    $count = 0;
    $gate  = rand(0, $sum);

    foreach ($ads as $ad) {
        $count += $ad->rotation;

        if ($count >= $gate) {
            return $ad;
        }
    }

    return false;
}

?>
