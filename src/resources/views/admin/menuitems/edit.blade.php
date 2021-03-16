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
        The title of the menu item
    </x-cms-form-input>


    <x-cms-form-foreignkeyselect type="select" name="context_id" label="Attach to:" 
        model="AscentCreative\CMS\Models\MenuItem" :query="AscentCreative\CMS\Models\MenuItem::scoped( ['menu_id' => 1] )->orderBy('_lft')" value="{{ old('context_id', $model->context_id) }}">
    </x-cms-form-foreignkeyselect>

    <select name="context_type">
        <option value="first-child">First Child Of</option>
        <option value="before">Sibling Before</option> 
        <option value="after">Sibling After</option>
    </select>


@endsection