@extends('cms::admin.base.edit')

@section('screen-start')
        
    {{-- OPEN FORM TAG --}}
    <form action="/admin/settings" method="POST" id="frm_edit" enctype="application/x-www-form-urlencoded">
    @csrf

@overwrite


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
    
        <x-cms-form-input type="text" name="site_name" label="Site Name" value="{{ old('site_name', $model->site_name) }}">
            Shows in the tab label for all pages of the site
        </x-cms-form-input>

    </div>

    <div class="cms-screenblock bg-white rounded shadow" style="">

        {{-- <x-cms-form-textarea name="value" label="Value(s)" value="{{ old('value', '') }}"/> --}}

        



    </div>

@endsection