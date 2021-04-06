{{-- @dump($data) --}}

<div class="row" style="padding: 20px">
@foreach($data->items as $item) 

    <div class="col-md-{{$item->cols->width}} @if($item->cols->width < 6) hyphenbreak @endif">

        {!! $item->content !!}

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