@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

<select name="{{ $name }}" class="form-control">
@foreach($options as $key=>$opt)

    <option value="{{ $key }}" @if($value == $key) selected @endif>

        {!! $opt !!}

    </option>

@endforeach
</select>


@overwrite