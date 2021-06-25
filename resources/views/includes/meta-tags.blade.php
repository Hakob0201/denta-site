{!!
    MetaTag::setTags(
        [
            'keywords' => __('main.meta.keywords'),
            isset($article) ? '' : 'canonical' => url()->current(),
            'og_url' => url()->current(),
            'og_site_name' => config('meta-tags.default.og_site_name'),
            'og_type' => config('meta-tags.default.og_type'),
            'fb_admins' => config('meta-tags.default.fb_admins'),
        ]
    )->render();
!!}
