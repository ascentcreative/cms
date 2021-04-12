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

    <div class="items" style="width: 100%; display: flex; position: relative;">

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
         handle: '.blockitem-handle',
         axis: 'x',
         forcePlaceholderSize: true,
         revert: 100,
         start: function(event, ui) {
            console.log('start');
//            console.log($(ui.element)); //.parents('.items').find('.ui-sortable-placeholder'));

            $(ui.placeholder).css('height', $(ui.item).height() + 'px');

         //   $(ui.element).parents('.items').find('.ui-sortable-placeholder').css('background-color', 'green !important');

         },
         update: function(event, ui) {

            console.log($(ui.element).parents('.items').find('.ui-sortable-placeholder'));
            // reapply field indexes to represent reordering
            $('.items').each(function(rowidx) {

                $(this).find('.blockitem').each(function(idx) {

                    $(this).find('INPUT, SELECT, TEXTAREA').each(function(fldidx) {
                        //  console.log(idx + ' / ' + fldidx);
                        var ary = $(this).attr('name').split(/(\[|\])/);
                        ary[10] = idx; // need to careful not to break the index used here... can we be cleveredr about it?
                        $(this).attr('name', ary.join(''));

                        $(this).change();
                        
                    });

                });

            });

        }

     });



    $('.blockitem').resizable({
        handles: 'e',
        placeholder: 'ui-state-highlight',
        start: function(event, ui){
            // sibTotalWidth = ui.originalSize.width + ui.originalElement.next().outerWidth();
            console.log(ui.size);

            var colcount = 12; // change this to alter the number of cols in the row.

            var colsize = $(ui.element).parents('.items').width() / colcount;
            // set the grid correctly - allows for window to be resized bewteen...
            $(ui.element).resizable('option', 'grid', [ colsize, 0 ]);
            
            // calc the max possible width for this item (to prevent dragging larger than the row)
            // get the col counts of items in the row
            var filled = 0;
            $(ui.element).parents('.items').find('.blockitem').each(function() {
                filled += parseInt($(this).find('.item-col-count').val());
                console.log(filled);
            });
            // subtract the col count of this item
            filled -= $(ui.element).find('.item-col-count').val();

            // the difference is the max number of cols this can fill
            empty = (colcount - filled);

            console.log(empty);

            // multiply to get a total max width.
            $(ui.element).resizable('option', 'maxWidth', colsize * (colcount - filled));


        },

        resize: function(event, ui) {
           
            console.log(ui.size.width + " :: " + $(ui.element).parents('.items').width());

            // calculate the number of cols currently occupied and write to the col-count field
            cols = (ui.size.width / $(ui.element).parents('.items').width()) * 12; // need to pull this from the same parameter as in 'start' - should probably widgetise this code...
            $(ui.element).find('.item-col-count').val(cols);
            
        }
    });
</script>
@endpush

