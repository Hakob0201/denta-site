<?php
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <title><![CDATA[{{ __('main.meta.title') }} - RSS]]></title>
        <link>{{ env('APP_URL') }}</link>
        <description>{{ __('main.meta.description') }}</description>
        <language>{{ $locale }}</language>
        <pubDate>{{ date('r') }}</pubDate>
        <image>
            <url>{{ env('APP_URL') }}/fav/android-icon-192x192.png</url>
            <title><![CDATA[{{ __('main.meta.title') }} - RSS]]></title>
            <link>{{ env('APP_URL') }}</link>
        </image>
        <atom:link href="{{ env('APP_URL') }}/{{ $locale }}/rss" rel="self" type="application/rss+xml"/>

        @foreach($articles as $article)
            <item>
                <title><![CDATA[{{ $article->contents->title }}]]></title>
                <description><![CDATA[{{ preg_replace('/\s+/S', " ", $article->contents->anons) }}]]></description>
                @foreach($article->authors as $author)
                    <author>{{ $author->fullname }}</author>
                    @break
                @endforeach
                <link>{{ route('article', ['article' => $article->id]) }}</link>
                <guid>{{ route('article', ['article' => $article->id]) }}</guid>
                <pubDate>{{ date('r', strtotime($article->contents->datetime_at)) }}</pubDate>
                @if($article->image)
                    <enclosure url="{{ env('APP_URL') }}/storage{{ $article->image->url . 'l-' . $article->image->name }}" type="image/jpeg" length="{{  File::size(storage_path('/app/public' . $article->image->url . 'l-' . $article->image->name))  }}"/>
                @endif
            </item>
        @endforeach
    </channel>
</rss>
