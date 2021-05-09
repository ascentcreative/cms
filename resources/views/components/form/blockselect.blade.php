@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')


    <div class="cms-blockselect cms-blockselect-columns-{{$columns}}" data-max-select="{{$maxSelect}}" @isset($maxHeight) style="max-height: {{$maxHeight}}; overflow-y: scroll"@endisset>
    @foreach($options as $key=>$opt)
        <label for="{{$name}}-{{ Str::slug($key) }}" class="cms-blockselect-option">
            <input type="checkbox" name="{{$name}}{{$maxSelect!=1?'[]':''}}" id="{{$name}}-{{ Str::slug($key) }}" value="{{$key}}"

                @if(in_array($key, $value)) checked @endif
            />

            @if($blockblade)
                @include($blockblade, ['option'=>$opt])
            @else
                @if($optionLabelField)
                    {{$opt->$optionLabelField}} 
                @else
                    {{$opt}}
                @endif
            @endif
        </label>
    @endforeach
    </div>

@overwrite

@once
    @push('styles')
        @style('/vendor/ascent/cms/form/components/ascent-blockselect.css')
    @endpush

    @push('scripts')
        @script('/vendor/ascent/cms/form/components/ascent-blockselect.js')
    @endpush
@endonce