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
   
    <x-cms-form-input type="text" name="name" label="Name" value="{{ old('name', $model->name) }}">
        The name of the role
    </x-cms-form-input>

</div>

<div class="cms-screenblock bg-white rounded shadow" style="">


    <x-cms-form-foreignkeyselect type="checkbox" name="permissions" label="Permissions" :value="old('permissions', $model->getPermissionNames())"
        :query="\Spatie\Permission\Models\Permission::query()" labelField="name" idField="name"
        >
    </x-cms-form-foreignkeyselect>

</div>


@endsection