@foreach($stack->blocks as $block)
{{-- {{ 'contentstack. ' . $block->template->slug . '.show' }} --}}
    @includeFirst(['contentstack.' . $block->template->slug . '.show', 'cms::contentstack.' . $block->template->slug . '.show'], ['data'=>json_decode($block->data, false)]) 
@endforeach