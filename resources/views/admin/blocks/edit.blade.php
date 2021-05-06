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

    <x-cms-form-checkbox type="" name="published" label="Published?" checkedValue="1" uncheckedValue="0" value="{{ old('published', $model->published) }}" />

    


</div>

<div class="cms-screenblock-tabs bg-white rounded shadow" style="">

    <ul class="nav nav-tabs px-3 pt-3 bg-light" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="block-tab" data-toggle="tab" href="#block" role="tab" aria-controls="block" aria-selected="true">Block Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="settiings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane show p-3" id="block" role="tabpanel" aria-labelledby="block-tab">
            {{-- Load the edit blade for the template --}}
            @includeFirst(['contentstack.' . $template->slug . '.edit', 'cms::contentstack.' . $template->slug . '.edit']) 

        </div>

        <div class="tab-pane show p-3" id="settings" role="tabpanel" aria-labelledby="settings-tab">

            @php $data = json_decode($model->data); @endphp

            <x-cms-form-colour name="data[bgcolor]" label="Background Colour" :value="old('data.bgcolor', $data->bgcolor ?? '')" />

            <x-cms-form-croppie label="Background Image" name="data[bgimage]" :value="old('data.bgimage', $data->bgimage ?? '')"  width="2000" height="600">
            </x-cms-form-croppie>

        </div>

    </div>

   
    

   

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