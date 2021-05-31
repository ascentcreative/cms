{{-- @dump($data) --}}

<div class="row" style="padding: 0px 0 20px">
@foreach($data->items as $item) 

    <div class="col-md-{{$item->cols->width}} xcol-sm-{{$item->cols->width * 2}} @if($item->cols->width < 6) hyphenbreak @endif" style="xpadding-bottom: 20px;">

        @switch($item->type)
            @case('text')
                {!! $item->content !!}
                @break

            @case('image')
                <IMG src="{{ $item->image }}" width="100%"/>
                @break

            @case('video')
                {{ embedVideo('https://youtu.be/VkDL6nFPHKU') }}
                @break

        @endswitch

    </div>


@endforeach
</div>


{{-- -ms-word-break: break-all;
     word-break: break-all;

     /* Non standard for WebKit */
     word-break: break-word;

-webkit-hyphens: auto;
   -moz-hyphens: auto;
        hyphens: auto; --}}