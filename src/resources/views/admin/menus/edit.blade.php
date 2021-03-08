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
   
    <x-cms-form-input type="text" name="title" label="Title" value="{{ old('title', $model->title) }}">
        The title of the menu
    </x-cms-form-input>

@endsection