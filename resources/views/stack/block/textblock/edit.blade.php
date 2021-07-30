@extends('cms::stack.base.edit')

@section('block-content')

    {{-- <div class="textblock">



    </div>

    <div class="" style=""
    <textarea id="text_123" name="block[123][text]">123</textarea> --}}

    <x-cms-form-wysiwyg label="TESTING" name="content{{ uniqid() }}" :value="old('content', 'fwfwefwefwef')" wrapper="none"/>

@overwrite


@section('block-settings') 

    <x-cms-form-input type="text" name="block[123][bgcolour]" value="{{ old('block.123.bgcolor', 'bgcolor') }}" label="bg colour" wrapper="simple"/>

@overwrite


@section('block-actions')
@overwrite

