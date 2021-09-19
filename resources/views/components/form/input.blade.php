@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <input type="{{$type}}" name="{{$name}}" value="{!! $value !!}" @if($type=='file' && $accept != '') accept="{{ $accept }}" @endif
        class="form-control{{ ($type=='file' ? '-file' : '') }}"
        @if($type=='number') min="0" step="0.01" @endif
        autocomplete="{{ $autocomplete ? 'on' : 'off' }}"
    />

@overwrite