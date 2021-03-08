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

<div class="cms-screenblock bg-white rounded shadow" style="">
   
    <x-cms-form-input type="text" name="title" label="Title" value="{{ old('title', $model->title) }}">
        The title of the page
    </x-cms-form-input>

</div>

<div class="cms-screenblock bg-white rounded shadow" style="">

    <x-cms-form-ckeditor type="text" label="Page Content" name="content" value="{{ old('content', $model->content) }}" height="600">

    </x-cms-form-ckeditor>

</div>

{{--
@foreach($model->getExtenders() as $extender)
<div class="cms-screenblock bg-white rounded shadow" style="">
    @include($extender->editBladePath)
</div>
@endforeach
--}}

@endsection