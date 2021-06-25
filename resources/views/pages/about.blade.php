@extends('layouts.app')

@section('content')

<section class="px-16 pt-45">
    <div class="container lg:flex justify-between">
        <h2 class="text-24 mb-30 text-primary-50">{{ $page->title }}</h2>
        <div class="article-body static-body text-18 text-primary-100">
            {!! $page->body !!}
        </div>
    </div>
</section>

{{--<section class="px-16 pt-45">--}}
{{--    <div class="container lg:flex justify-between">--}}
{{--        <h2 class="text-24 mb-30 text-primary-50">{{ __('main.about.members') }}</h2>--}}
{{--        <div class="static-body w-full text-18 text-primary-100 flex flex-wrap">--}}
{{--            @foreach(App\Author::where('onoff', 1)->get() as $author)--}}
{{--                <div class="authors pr-16 flex-grow flex mb-45">--}}
{{--                    <img class="rounded-full" src="/storage/static/authors/{{ $author->id }}.jpg" alt="{{ $author->fullname }}">--}}
{{--                    <div class="flex flex-col justify-center ml-45">--}}
{{--                        <p class="text-18 pb-12">{{ $author->fullname }}</p>--}}
{{--                        <p class="text-16 text-primary-50">{{ $author->position }}</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

<section class="px-16 pt-45">
    <div class="container lg:flex justify-between">
        <h2 class="text-24 mb-30 text-primary-50">{{ __('main.about.contacts') }}</h2>
        <div class="static-body text-18 text-primary-100 flex flex-wrap">
            <iframe src="https://maps.google.com/maps?q=%D4%B5%D6%80%D6%87%D5%A1%D5%B6,%20%D4%B1%D6%80%D5%B7%D5%A1%D5%AF%D5%B8%D6%82%D5%B6%D5%B5%D5%A1%D6%81%202%D5%A1,%20%D5%84%D5%A1%D5%B4%D5%B8%D6%82%D5%AC%D5%AB%20%D5%B7%D5%A5%D5%B6%D6%84&t=&z=17&ie=UTF8&iwloc=&output=embed" width="100%" height="420px" frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            <div class="flex flex-wrap text-primary-50 space-x-45 pt-16">
                @if(config('site.contacts.address.' . $locale))
                    <p>{{ config('site.contacts.address.' . $locale) }}</p>
                @endif
                @include('includes.contacts')
            </div>
        </div>
    </div>
</section>

@stop
