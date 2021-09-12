@extends('cms::modal')

@php
    $modalFade = false;
    $modalShowHeader = true;
    //$modalShowFooter = true;
    $modalCenterVertical = false;
    $modalSize = "modal-lg";
@endphp

@section('modalTitle')
Save Filters
@endsection


@section('modalContent')

        <form action="{{ route('savedfilters.create') }}" data-onsuccess="refresh" class="xno-ajax" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}  


            <div class="bg-light border rounded p-3 mb-3 flex flex-between">
                This will save all selected filters, sorting options and the number of rows to display, as currently configured on the page.
             </div>


            <div class="border p-3 mb-3">

                <x-cms-form-input name="name" value="{{ old('name', '') }}" label="Filter Name" type="text" aria-autocomplete="false" />

                <x-cms-form-checkbox name="is_global" checkedValue="1" uncheckedValue="0" label="Visible to all users?" wrapper="inline" type="" value=""/>

            </div>


            <div class="pb-3 flex flex-between">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Save</button>
            </div>

        </form>
        

@endsection




@push('scripts')

@endpush