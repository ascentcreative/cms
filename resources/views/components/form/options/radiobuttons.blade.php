@extends('cms::components.form.wrapper.' . $wrapper)

@section('element')

@foreach($options as $key=>$opt)

    <label for="{{ nameToId($name) }}-{{$key}}">

        <input type="radio" value="{{ $key }}" id="{{ nameToId($name) }}-{{$key}}" name="{{ $name }}" @if($value == $key ) checked @endif>
        <span>{{ $opt }}</span>

    </label>

@endforeach

@overwrite

