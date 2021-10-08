@extends('cms::components.form.wrapper.' . $wrapper)

@php $tmp_label = $label; @endphp
@section('name'){{$name}}@overwrite

@section('element')

    <div class="border p-3 bg-light w-50">

        <div class="hasmany-items">
     
            @foreach($value as $idx=>$item)

                @include('admin.' . $source . '.hasmany.' . $target . '.item', ['item'=> (object) $item, 'name'=>$name . '[' . $idx . ']' ] )

            @endforeach

        </div>
    
        {{-- Derive route name from parent and target models --}}
        <a href="{{ route('cms.components.hasmany', ['source'=>$source, 'target'=>$target]) }}" class="button btn btn-sm btn-primary modal-link" xdata-toggle="modal" xdata-target="#hasmanyedit">Add New</a>

    </div>

@overwrite

@section('label'){{$tmp_label}}@overwrite

@push('scripts')
<script>

$(document).on('modal-link-response', function(e) {

    $('.hasmany-items').append(e.response);

});

</script>


{{-- <script>
    $(document).on('click', 'button#hasmany-create', function(e) {
        
        e.preventDefault();

        // do something to add the new row...
        // I'm guessing an ajax submit, but how do we tell it where to send it, and what blade to respond with?
        // what if we had a template holding a blank row, with labelled placeholders for the data?

    });
</script> --}}
@endpush