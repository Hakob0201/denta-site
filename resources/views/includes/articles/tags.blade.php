<div class="text-15 text-{{ $color }} space-x-12 mt-12">
    @foreach($item->tags as $tag)
        <a class="transition duration-300 hover:opacity-80 hover:border-opacity-80 border-b-2 border-opacity-0 border-{{ $color }}" href="/{{ $locale }}/tag/{{ $tag->tag_slug }}">#{{ $tag->tag_name }}</a>
    @endforeach
</div>
