@extends('cms::stack.block.base.edit')

@php 

// set a default value

if(is_null($value) || $value == '') {

    $obj =  [  'items' =>   [
            (object) [
                        'type'=>'text'
            ]]
    ];

    $value = (object) $obj;

}

@endphp


@section('block-content')

    <div class="container row items">

        @if($value)
            @isset($value->items)
                @foreach($value->items as $key=>$item)
                    <x-cms-form-stackblock-rowitem name="{{ $name }}[items][{{$key}}]" :value="$item" />
                @endforeach
            @endisset
        @endif

    </div>


    {{--  --}}

@overwrite


@section('block-settings') 

    {{-- <x-cms-form-input type="text" name="{{$name}}[bgcolor]" value="{{ !is_null($value) ? $value->bgcolor : '' }}" label="bg colour" wrapper="simple"/> --}}
        <x-cms-form-input type="text" name="{{$name}}[bgcolor]" value="{{ isset($value->bgcolor) ? $value->bgcolor : '' }}" label="bg colour" wrapper="simple"/>

@overwrite

@push('scripts')
<script>
     $('.items').sortable({
         handle: '.blockitem-handle'
     });


    $('.blockitem').resizable({
        handles: 'e, w',
        start: function(event, ui){
            // sibTotalWidth = ui.originalSize.width + ui.originalElement.next().outerWidth();
            
            // set the grid correctly - allows for window to be resized bewteen...
            $(ui.element).resizable('option', 'grid', $(ui.element).parents('.items').width() / 12);
            
            // swap all col-* classes for %ge widths and drop col widths into data objects
            // or should we just use the col widths as data anyway?
            
            // highlight grabbed element?

        },
        stop: function(event, ui) {
            // convert data back?
        },
        resize: function(event, ui) {
           
            // this fires on grid snap (not every mouse pixel) so we can use it to grab the next or previous element
            // and reszie that too?

            console.log(ui.size);
        }
    });
</script>
@endpush

