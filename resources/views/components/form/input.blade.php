@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <input type="{{$type}}" name="{{$name}}" value="{!! $value !!}" class="form-control"/>

@overwrite