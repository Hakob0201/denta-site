<script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "NewsArticle",
        "mainEntityOfPage": "{{ url()->current() }}",
        "url": "{{ url()->current() }}",
        "name": "{{ $article->contents->title }}",
        "headline": "{{ mb_strlen($article->contents->title) > 110 ? mb_substr($article->contents->title, 0, 107) . '...' : $article->contents->title }}",
        "description": "{{ $article->contents->anons }}",
    @if($article->image)
        "image": [
			"{{ config('app.url') }}/storage{{ $article->image->url . 'l-' . $article->image->name }}"
		],
    @endif
    "datePublished": "{{ date('c', strtotime($article->contents->datetime_at)) }}",
        "dateModified": "{{ date('c', strtotime($article->contents->updated_at)) }}",
    @if($article->authors->count()>0)
        @foreach($article->authors as $author)
            "author": {
                "@type": "Person",
                "name": "{{ $author->fullname }}"
        },
        @break
        @endforeach
    @else
        "author": {
            "@type": "Organization",
            "name": "Ejc"
        },
    @endif
    "publisher": {
        "@type": "Organization",
        "name": "Ejc",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ config('app.url') }}/assets/fav/ms-icon-310x310.png",
                "width": 310,
                "height": 310
            }
        }
    }
</script>
