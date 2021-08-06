<div class="row" style="padding: 0px 0 20px">
@isset($data->items)
    @foreach($data->items as $item) 

        <div class="col-md-{{$item->cols->width}} xcol-sm-{{$item->cols->width * 2}} @if($item->cols->width < 6) hyphenbreak @endif" style="xpadding-bottom: 20px; xwhite-space: pre-wrap; xtab-size: 10;">

            @switch($item->type)
                @case('text')
                    {!! $item->content !!}
                    @break

                @case('image')
                    <IMG src="{{ $item->image }}" width="100%" height="100%" style="object-fit: contain; object-position: top"/>
                    @break

                @case('video')
                    {{ embedVideo( $item->video ) }}
                    @break

            @endswitch

        </div>

    @endforeach
@endisset
</div>