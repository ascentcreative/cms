{{-- {!! $content !!} --}}



@foreach(json_decode($content) as $item)

    @include('cms::stack.block.' . $item->type . '.show', ['data'=>$item])

@endforeach