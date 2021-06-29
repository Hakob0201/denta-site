
@forelse($articles as $item)
    <!-- Post Item #1 -->
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="post-item">
            <div class="post__img">
                <a href="/{{ $locale }}/article/{{ $item->id }}">
                    @if(isset($item->image) && !empty($item->image))
                            <img src="/storage{{ $item->image->url . (isset($type) ? $type : '') . $item->image->name }}" alt="{{ $item->contents ? $item->contents->title : $item->title }}" style="width: 100%;">
                        @else 
                            <img src="{{ asset('assets/images/blog/grid/1.jpg') }}" alt="post image" loading="lazy" />
                    @endif
                    
                </a>
            </div>
            <!-- /.post__img -->
            <div class="post__body">
                <div class="post__meta-cat">
                    <a href="/{{ $locale }}/article/{{ $item->id }}">Mental Health</a>
                </div>
                <!-- /.blog-meta-cat -->
                <div class="post__meta d-flex">
                    <span class="post__meta-date">{{ $item->contents->datetime_at }}</span>
                    {{-- <a class="post__meta-author">Martin King</a> --}}
                </div>
                <h4 class="post__title">
                    <a href="/{{ $locale }}/article/{{ $item->id }}">{{ $item->contents->title }}</a>
                </h4>
                <p class="post__desc">
                    {!! $item->contents->text ?? '' !!}                
                </p>
                <a href="/{{ $locale }}/article/{{ $item->id }}" class="btn btn__secondary btn__link btn__rounded">
                    <span>Read More</span>
                    <i class="icon-arrow-right"></i>
                </a>
            </div>
            <!-- /.post__body -->
        </div>
        <!-- /.post-item -->
    </div>
    <!-- /.col-lg-4 -->
@empty
    <h1 class="text-primary-50 text-28 mb-45 col-span-6">{{ __('main.no-articles') }}</h1>
    <div></div>
@endforelse

