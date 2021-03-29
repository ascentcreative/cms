@extends('cms::admin.base.edit')


@section('editform')

<div class="cms-screenblock cms-screenblock-main bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="name" label="Name" value="{{ old('name', $model->name) }}">
        The name of the permission
    </x-cms-form-input>



</div>



@endsection