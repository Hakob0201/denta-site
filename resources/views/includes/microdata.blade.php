<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "@id": "{{ url()->current() }}",
    "mainEntityOfPage": "{{ url()->current() }}",
    "headline": "{{ $article->contents->title }}",
@if($article->image)
        "image": {
            "@type": "ImageObject",
@if($article->authors->count() > 0)
            @foreach($article->authors as $author)
            "author": {
                "@type": "Person",
                "name": "{{ $author->fullname }}"
            },
@break
            @endforeach
        @else
            "author": {
                "@type": "Person",
                "name": "ejc.am"
            },
@endif
        "contentLocation": "Armenia",
        "contentUrl": "{{ config('app.url') }}/storage{{ $article->image->url . 'l-' . $article->image->name }}",
        "datePublished": "{{ date('c', strtotime($article->contents->datetime_at)) }}",
        "name": "{{ $article->contents->title }}",
        "url": "{{ config('app.url') }}/storage{{ $article->image->url . 'l-' . $article->image->name }}"
    },
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
            "@type": "Person",
            "name": "ejc.am"
        },
@endif
    "publisher": {
        "@type": "Organization",
        "name": "Ejc",
        "logo": {
            "@type": "ImageObject",
            "contentUrl": "{{ config('app.url') }}/assets/fav/ms-icon-310x310.png",
            "width": 310,
            "height": 310,
            "url": "{{ config('app.url') }}/assets/fav/ms-icon-310x310.png"
        }
    },
    "description": "{{ $article->contents->anons }}"
}
</script>
