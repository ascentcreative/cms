{{-- {!! $content !!} --}}



@foreach(json_decode($content) as $item)

    @includeFirst(['stack.block.' . $item->type . '.show', 'cms::stack.block.' . $item->type . '.show'], ['data'=>$item])

@endforeach