@extends('cms::admin.base.edit')


@push('scripts')
    @script('/vendor/ascent/cms/jquery/areyousure/jquery.are-you-sure.js')
    @script('/vendor/ascent/cms/jquery/areyousure/ays-beforeunload-shim.js')

    <script language="javascript">
        $(document).ready(function() {
            $('#frm_edit').areYouSure( {'message':'Your edits have not been saved!'} );
	
        });
    </script>

    <script>

        $(document).ready(function() {
            $('#myTab li:first-child a').tab('show');
        });

    </script>

@endpush


@section('editform')

<div class="cms-screenblock cms-screenblock-main bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="title" label="Title" value="{{ old('title', $model->title) }}">
        The title of the page
    </x-cms-form-input>

</div>

<div class="cms-screenblock-tabs bg-white rounded shadow" style="">


    <ul class="nav nav-tabs px-3 pt-3 bg-light" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="main-tab" data-toggle="tab" href="#page" role="tab" aria-controls="page" aria-selected="true">Page Content</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="headimg-tab" data-toggle="tab" href="#headimg" role="tab" aria-controls="headimg" aria-selected="false">Header Image</a>
          </li>
        <li class="nav-item">
          <a class="nav-link" id="menuitem-tab" data-toggle="tab" href="#menuitem" role="tab" aria-controls="menuitem" aria-selected="false">Menu Position</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane show p-3" id="page" role="tabpanel" aria-labelledby="page-tab">

            <x-cms-form-ckeditor type="text" label="Page Content" name="content" value="{{ old('content', $model->content) }}" height="500">

            </x-cms-form-ckeditor>
        

        </div>

        <div class="tab-pane show p-3" id="headimg" role="tabpanel" aria-labelledby="headimg-tab">

            @includeFirst($model->getTraitBlades('HasHeaderImage'))

        </div>

        <div class="tab-pane show p-3" id="menuitem" role="tabpanel" aria-labelledby="meuitem-tab">

            @includeFirst($model->getTraitBlades('HasMenuItem'))

        </div>

    </div>

    
</div>


@endsection