<div class="languages inline-flex flex-col-reverse lg:flex-row right-0 bg-white lg:bg-none fixed lg:static self-center border rounded border-primary-20 h-auto text-primary-50 lg:text-primary-20 lg:border-opacity-50 font-semibold uppercase text-14 mx-16">
    @foreach(config('language.preview') as $key => $title)
        <a class="hover-orange @if($locale == $key) selected text-center @endif"  @if($locale != $key) href="{{ str_replace('/' . app()->getLocale(), $key, '/' . request()->path()) }}" @endif>{{ $title }}</a>
    @endforeach
</div>
