@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <div class="cms-blockselect" data-max-select="{{$maxSelect}}">
    @foreach($options as $opt)
        <label for="{{$name}}-{{ Str::slug($opt) }}" class="cms-blockselect-option"><input type="{{$maxSelect==1?'radio':'checkbox'}}" name="{{$name}}{{$maxSelect!=1?'[]':''}}" id="{{$name}}-{{ Str::slug($opt) }}" value="{{$opt}}"/>{{$opt}}</label>
    @endforeach
    </div>

@overwrite

@push('styles')
    @style('/vendor/ascent/cms/form/components/ascent-blockselect.css')
@endpush

@push('scripts')
    @script('/vendor/ascent/cms/form/components/ascent-blockselect.js')
@endpush