@extends('cms::admin.base.edit')

@section('editform')
   
    <x-cms-form-input type="text" name="name" label="Name" value="{{ old('name', $model->name) }}">
        The title of the stack
    </x-cms-form-input>

@endsection