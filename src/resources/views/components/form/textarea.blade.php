@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <textarea name="{{$name}}" class="form-control">{{$value}}</textarea>

@overwrite