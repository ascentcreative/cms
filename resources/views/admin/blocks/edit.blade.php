@extends('cms::admin.base.edit')

@php
    
    $template = $model->template;

    if(!$template) {
        $template = \AscentCreative\CMS\Models\BlockTemplate::find(request()->blocktemplate_id);
    }

@endphp

@section('editform')

<div class="cms-screenblock bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="name" label="Name" value="{{ old('name', $model->name) }}">
        The name of the menu item (internal use only - if there's a display title, list that below). 
    </x-cms-form-input>

    <x-cms-form-statictext label="Template">

        <div><B>{{ $template->name }}</B></div>

        <div>{{ $template->description }}</div>



    </x-cms-form-statictext>


    <x-cms-form-hidden name="stack_id" value="{{ old('stack_id', $model->stack_id ?? request()->stack_id ) }}" />

    <x-cms-form-hidden name="blocktemplate_id" value="{{ old('blocktemplate_id', $model->blocktemplate_id ?? request()->blocktemplate_id ) }}" />


</div>

<div class="cms-screenblock bg-white rounded shadow" style="">

    {{-- Load the edit blade for the template --}}
    @includeFirst(['contentstack.' . $template->slug . '.edit', 'cms::contentstack.' . $template->slug . '.edit']) 

  

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