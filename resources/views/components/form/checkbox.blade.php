@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    {{-- @dump($value)
    @dump($checkedValue)
    @dump($value == $checkedValue) --}}

    <div style="display: flex; align-items: center; height: 100%;">
        <input type="checkbox" id="{{$name}}" name="{{$name}}" value="{{$checkedValue}}"
        
        @if($value == $checkedValue)
        checked
        @endif
        
        />
        {{-- <div class="flex-label-text">@if($labelescape){{$label}}@else{!! $label !!}@endif</div> --}}
    </div>

@overwrite