@extends('cms::admin.base.edit')


@section('editform')

<div class="cms-screenblock cms-screenblock-main bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="name" label="Name" value="{{ old('name', $model->name) }}">
        The real name of the user
    </x-cms-form-input>

    <x-cms-form-input type="text" name="email" label="Emaiil" value="{{ old('email', $model->email) }}">
        Their email address (also used for logging in etc)
    </x-cms-form-input>

</div>

<div class="cms-screenblock bg-white rounded shadow" style="">


    <x-cms-form-foreignkeyselect type="checkbox" name="roles" label="Roles" :value="old('roles', $model->roles)"
        :query="\Spatie\Permission\Models\Role::query()" labelField="name" idField="name"
        >
        Be careful editing this value if this is your own record. You may lock yourself out...
    </x-cms-form-foreignkeyselect>


    <x-cms-form-foreignkeyselect type="checkbox" name="permissions" label="Permissions" :value="old('permissions', $model->permissions)"
        :query="\Spatie\Permission\Models\Permission::query()" labelField="name" idField="name"
        >
        Be careful editing this value if this is your own record. You may lock yourself out...
    </x-cms-form-foreignkeyselect>

</div>


@endsection