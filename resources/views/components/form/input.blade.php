@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <input type="{{$type}}" name="{{$name}}" value="{!! $value !!}" class="form-control"
        @if($type=='number') min="0" step="0.01" @endif
    />

@overwrite