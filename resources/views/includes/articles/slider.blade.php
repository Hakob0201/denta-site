@if($article->images->count()>0)
    <div class="owl-carousel article-slider @if(!isset($slider_id)) full-cont @endif">
        @foreach($article->images as $imgkey => $img)
            @if(!isset($slider_id) || $img->slider == $slider_id)
                <div class="slider-item">
                    <div class="image-block">
                        <img src="/storage{{ $img->url . 'l-' . $img->name }}" alt="">
                    </div>
                    @if($img->pivot->show_title)
                        <div class="content-block">
                            <span class="description">{{ $img->title->$locale }}</span>
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
@endif
