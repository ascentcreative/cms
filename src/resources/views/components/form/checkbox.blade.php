@extends('cms::components.form.wrapper.' . $wrapper)

@section('label')@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <label for="{{$name}}" class="flex-label">
        <input type="checkbox" id="{{$name}}" name="{{$name}}" value="{{$value}}" {{ old('emailsignup') == 1 ? 'checked' : '' }}/>
        <div class="flex-label-text">{{$label}}</div>
    </label>
   

@overwrite