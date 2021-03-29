@extends('cms::admin.base.edit')



@section('editform')
   
    <x-cms-form-input type="text" name="title" label="Title" value="{{ old('title', $model->title) }}">
        The title of the menu
    </x-cms-form-input>

@endsection