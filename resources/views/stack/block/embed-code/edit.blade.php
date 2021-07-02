@extends('cms::stack.block.base.edit')


@section('block-content')

    <x-cms-form-code label="Code" name="{{ $name }}[code]" :value="$value->code" wrapper="none"/>

@overwrite