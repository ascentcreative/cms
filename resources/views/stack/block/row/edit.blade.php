@extends('cms::stack.block.base.edit')

@php 

$unid = 'sbe-' . uniqid();

// set a default value

// if(is_null($value) || $value == '') {

//     $obj =  [  'items' =>   [
//             (object) [
//                         'type'=>'text'
//             ]]
//     ];

//     $value = (object) $obj;

// }

@endphp

@section('block-content')

    {{-- @dd($value) --}}

    <div class="items" id="{{ $unid }}" style="width: 100%; display: flex; flex-wrap: wrap; position: relative;">

        @if($value)
            @isset($value->items)
                @foreach($value->items as $key=>$item)
                    {{-- @dd($item) --}}
                    <x-cms-form-stackblock-rowitem type="{{ $item->type }}" name="{{ $name }}[items][{{$key}}]" :value="$item" />
                @endforeach
            @endisset
        @endif
        
        <div class="placeholder" @if( count((array) ($value->items ?? [])) > 0) style="display: none" @endif/>
            Add an item:
            <A href="#" class="block-add-item-text">Text</A> | <a href="#" class="block-add-item-image">Image</a> | <a href="#" class="block-add-item-video">video</a>
        </div>

    </div>


    {{--  --}}

@overwrite

@section('block-actions')

    <div class="btn-group dropleft">
        <A href="#" class="block-add-item bi-plus-circle-fill" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></A>
        <div class="dropdown-menu">
            <A href="#" class="block-add-item-text dropdown-item bi-card-text"> Text</A>
            <A href="#" class="block-add-item-image dropdown-item bi-card-image"> Image</A>
            <A href="#" class="block-add-item-video dropdown-item bi-camera-reels-fill"> Video</A>
        </div>
    </div>

@endsection

@section('block-settings') 

    {{-- <x-cms-form-input type="text" name="{{$name}}[bgcolor]" value="{{ !is_null($value) ? $value->bgcolor : '' }}" label="bg colour" wrapper="simple"/> --}}
        <x-cms-form-input type="text" name="{{$name}}[bgcolor]" value="{{ isset($value->bgcolor) ? $value->bgcolor : '' }}" label="bg colour" wrapper="simple"/>

@overwrite

@push('scripts')
<script>
    $(document).ready(function() {
        $('#{{ $unid }}').parents('.block-edit').stackblockedit();
    });

</script>
@endpush


