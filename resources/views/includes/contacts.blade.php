@foreach(config('site.contacts.phone') as $key => $value)
    <a class="whitespace-no-wrap" href="tel:{{ str_replace(' ', '', str_replace('-', '', str_replace('(' , '', str_replace(')', '', $value)))) }}">{{ $value }}</a>
@endforeach

@foreach(config('site.contacts.email') as $key => $value)
    <a class="whitespace-no-wrap" href="mailto:{{ $value }}">{{ $value }}</a>
@endforeach
