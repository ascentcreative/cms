@extends('cms::components.form.staticwrapper.' . $wrapper)

@section('label'){{$label}}@overwrite


@section('element')

    {{ $slot }}

@overwrite