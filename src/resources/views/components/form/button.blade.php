@extends('cms::components.form.wrapper.' . $wrapper)

@section('label')@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <button name="{{$name}}" value="{{$value}}">{{$label}}</button>

@overwrite