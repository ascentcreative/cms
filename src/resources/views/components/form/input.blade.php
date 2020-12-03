@extends('cms::components.form.bootstrapformgroup')

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')
xyz
    <input type="{{$type}}" name="{{$name}}" value="{{$value}}" class="form-control"/>

@overwrite