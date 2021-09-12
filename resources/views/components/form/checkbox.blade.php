@extends('cms::components.form.wrapper.' . $wrapper)

@section('label')
@if($labelAfter)

@else
    {{$label}}
@endif
@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    @if(!is_null($uncheckedValue))
        <input type="hidden" id="{{$name}}-unchecked" name="{{$name}}" value="{{$uncheckedValue}}"/>
    @endif
    <div style="display: flex; align-items: center; height: 100%;" class="pt-1">
        <input type="checkbox" id="{{$name}}" name="{{$name}}" value="{{$checkedValue}}"
        
        @if($value == $checkedValue)
        checked
        @endif
        
        />



        @if($labelAfter)
            <label class="flex-label-text pl-3 mb-0" for="{{$name}}">@if($labelEscape){{$label}}@else{!! $label !!}@endif</label>
        @endif
    </div>

@overwrite