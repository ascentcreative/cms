@extends('cms::admin.base.edit')




@section('editform')

<div class="cms-screenblock cms-screenblock-main bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="name" label="Name" value="{{ old('name', $model->name) }}">
        The name of the role
    </x-cms-form-input>

</div>

<div class="cms-screenblock bg-white rounded shadow" style="">


    <x-cms-form-foreignkeyselect type="checkbox" name="permissions" label="Permissions" :value="old('permissions', $model->getPermissionNames())"
        :query="\Spatie\Permission\Models\Permission::query()" labelField="name" idField="name"
        >
    </x-cms-form-foreignkeyselect>

</div>


@endsection