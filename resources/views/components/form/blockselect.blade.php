@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <div class="cms-blockselect" data-max-select="{{$maxSelect}}">
    @foreach($options as $key=>$opt)
        <label for="{{$name}}-{{ Str::slug($key) }}" class="cms-blockselect-option"><input type="{{$maxSelect==1?'radio':'checkbox'}}" name="{{$name}}{{$maxSelect!=1?'[]':''}}" id="{{$name}}-{{ Str::slug($key) }}" value="{{$key}}"/>
            @if($blockblade)
                @include($blockblade, ['option'=>$opt])
            @else
                {{$opt}}
            @endif
        </label>
    @endforeach
    </div>

@overwrite

@push('styles')
    @style('/vendor/ascent/cms/form/components/ascent-blockselect.css')
@endpush

@push('scripts')
    @script('/vendor/ascent/cms/form/components/ascent-blockselect.js')
@endpush