@extends('cms::admin.base.edit')


@section('editform')

<div class="cms-screenblock bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="title" label="Title" value="{{ old('title', $model->title) }}">
        The title of the menu item
    </x-cms-form-input>

    <x-cms-form-input type="text" name="url" label="URL" value="{{ old('url', $model->url) }}">
        The URL to link to
    </x-cms-form-input>

    <x-cms-form-checkbox type="" name="newWindow" label="Open in New Window" :value="old('newWindow', $model->newWindow)" uncheckedValue="0"/>

</div>

<div class="cms-screenblock bg-white rounded shadow" style="">

    <x-cms-form-nestedset label="Menu" name="_menuitem"

    scopeFieldName="menu_id"
    relationshipFieldName="context_type"
    relationFieldName="context_id"
    :scopeData="AscentCreative\CMS\Models\Menu::query()"
    scopeKey="menu_id"
    :nestedSetData="AscentCreative\CMS\Models\MenuItem::query()"

    scopeValue="{{ old('menu_id', $model->menu_id ?? request()->menu_id ) }}"
    relationshipValue="{{ old('context_type', $model->context['position'] ) }}"
    relationValue="{{ old('context_id', $model->context['reference'] ) }}"

    >

</x-cms-form-nestedset>

</div>


    {{-- <x-cms-form-menuposition label="Position As" name="_menuitem" contextType="" contextId="">

    </x-cms-form-menuposition> --}}

{{-- 

    <x-cms-form-foreignkeyselect type="select" name="context_id" label="Attach to:" 
        model="AscentCreative\CMS\Models\MenuItem" :query="AscentCreative\CMS\Models\MenuItem::scoped( ['menu_id' => 1] )->orderBy('_lft')" value="{{ old('context_id', $model->context_id) }}">
    </x-cms-form-foreignkeyselect>

    <select name="context_type">
        <option value="first-child">First Child Of</option>
        <option value="before">Sibling Before</option> 
        <option value="after">Sibling After</option>
    </select> --}}


@endsection