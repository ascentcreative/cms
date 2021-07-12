@extends('cms::admin.base.edit')

@section('editform')

<div class="cms-screenblock cms-screenblock-main bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="title" label="Title" value="{{ old('title', $model->title) }}">
        The title of the page
    </x-cms-form-input>

    @includeFirst($model->getTraitBlades('HasMenuItem'))



</div>

<div class="cms-screenblock-tabs bg-white rounded shadow" style="">


    <ul class="nav nav-tabs px-3 pt-3 bg-light" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="main-tab" data-toggle="tab" href="#page" role="tab" aria-controls="page" aria-selected="true">Page Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="headimg-tab" data-toggle="tab" href="#headimg" role="tab" aria-controls="headimg" aria-selected="false">Images</a>
          </li>
        {{-- <li class="nav-item">
          <a class="nav-link" id="menuitem-tab" data-toggle="tab" href="#menuitem" role="tab" aria-controls="menuitem" aria-selected="false">Menu Position</a>
        </li> --}}
        <li class="nav-item">
            <a class="nav-link" id="metadata-tab" data-toggle="tab" href="#metadata" role="tab" aria-controls="metadata" aria-selected="false">Metadata</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane show p-3" id="page" role="tabpanel" aria-labelledby="page-tab">

            @switch(config('cms.content_editor'))

                @case('ckeditor')
                    <x-cms-form-ckeditor type="text" label="Page Content" name="content" value="{{ old('content', $model->content) }}" height="500">

                    </x-cms-form-ckeditor>
                @break

                @case('stack')
                    <x-cms-form-stack label="TESTING" 
                    name="content" 
                    :value="old('content', $model->content)" 
                    wrapper="none"/>
                @break

            @endswitch

            {{-- 
         --}}

         

            {{-- <x-cms-form-wysiwyg label="TESTING" name="content{{uniqid()}}" :value="old('content', $model->content)" wrapper="none"/> --}}

            


        </div>

        <div class="tab-pane show p-3" id="headimg" role="tabpanel" aria-labelledby="headimg-tab">

            @includeFirst($model->getTraitBlades('HasImages'))

        </div>

        {{-- <div class="tab-pane show p-3" id="menuitem" role="tabpanel" aria-labelledby="menuitem-tab">

           
        </div> --}}

        <div class="tab-pane show p-3" id="metadata" role="tabpanel" aria-labelledby="metadata-tab">

            @includeFirst($model->getTraitBlades('HasMetadata'))

        </div>

    </div>

    
</div>


@endsection
