@extends('cms::admin.base.edit')


@section('editform')

<div class="cms-screenblock bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="title" label="Title" value="{{ old('title', $model->title) }}">
        The name of the banner (internal use only). 
    </x-cms-form-input>

  
    <x-cms-form-hidden name="stack_id" value="{{ old('stack_id', $model->stack_id ?? request()->stack_id ) }}" />

    <x-cms-form-hidden name="blocktemplate_id" value="{{ old('blocktemplate_id', $model->blocktemplate_id ?? request()->blocktemplate_id ) }}" />

    <x-cms-form-checkbox type="" name="publishable" label="Published?" checkedValue="1" uncheckedValue="0" value="{{ old('publishable', $model->publishable) }}" />

    <x-cms-form-input type="date" name="start_date" label="Start" value="{{ old('start_date', $model->start_date) }}">
        Leave blank to start immediately
    </x-cms-form-input>

    <x-cms-form-input type="date" name="end_date" label="End" value="{{ old('end_date', $model->end_date) }}">
        Leave blank to run indefinitely
    </x-cms-form-input>


</div>

<div class="cms-screenblock-tabs bg-white rounded shadow" style="">

    <ul class="nav nav-tabs px-3 pt-3 bg-light" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="block-tab" data-toggle="tab" href="#block" role="tab" aria-controls="block" aria-selected="true">Banner Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="settiings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">

        <div class="tab-pane show p-3" id="block" role="tabpanel" aria-labelledby="block-tab">
           
            {{-- <x-cms-form-croppie label="Image" name="image_id" :value="old('image_id', $model->image_id ?? '')"  width="1000">
            </x-cms-form-croppie> --}}

            <x-cms-form-fileupload label="Image" name="image_id" :value="old('image_id', $model->image_id ?? '')">
            </x-cms-form-fileupload>

            <x-cms-form-checkbox type="" name="use_full_width" label="Use Full Width?" checkedValue="1" uncheckedValue="0" value="{{ old('use_full_width', $model->use_full_width) }}" />


            <x-cms-form-input type="text" name="link_url" label="Link URL" value="{{ old('link_url', $model->link_url) }}">
                The URL that the banner will link to
            </x-cms-form-input>

            <x-cms-form-colour name="bgcolor" label="Background Colour" :value="old('bgcolor', $model->bgcolor ?? '')" />

        </div>

        <div class="tab-pane show p-3" id="settings" role="tabpanel" aria-labelledby="settings-tab">

            @php $data = json_decode($model->data); @endphp

          
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