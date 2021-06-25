<div class="sticky top-0 bg-white lg:mb-45 shadow-lighter px-16 mb-16 print:hidden">
    <div class="container flex overflow-auto justify-between text-14 space-x-45 py-16 ">
        @foreach($currency as $item)
            <div class="flex flex-col">
                <div class="flex justify-between space-x-16">
                    <span class="text-primary-100 font-medium opacity-80">{{ $item->currency }}/AMD</span>
                    @if($item->difference < 0)
                        <span class="text-red font-semibold">▾{{ $item->value }}</span>
                    @else
                        <span class="text-green font-semibold">▴{{ $item->value }}</span>
                    @endif
                </div>
                <div class="flex justify-between space-x-16 text-primary-50">
                    <span>{{ ($item->difference > 0 ? '+' : '') . round(($item->value / ($item->value - $item->difference)) * 100 - 100, 2) }}%</span>
                    <span>{{ $item->difference > 0 ? '+' . $item->difference : $item->difference }}</span>
                </div>
            </div>
        @endforeach
{{--        <div></div>--}}
{{--        <div></div>--}}
    </div>
</div>
