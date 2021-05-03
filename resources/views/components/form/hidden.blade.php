@extends('cms::components.form.wrapper.none')

@section('name'){{$name}}@overwrite

@section('element')

    <input type="hidden" name="{{$name}}" value="{!! $value !!}"/>

@overwrite