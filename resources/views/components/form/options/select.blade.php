@extends('cms::components.form.wrapper.' . $wrapper)


@section('element')

<select name="{{ $name }}" class="form-control">
@foreach($options as $key=>$opt)

    <option value="{{ $key }}" @if($value == $key) selected @endif>

        {!! $opt !!}

    </option>

@endforeach
</select>


@overwrite