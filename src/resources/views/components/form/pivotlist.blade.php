@extends('cms::components.form.bootstrapformgroup')

@once
    @push('styles')
        @style(/vendor/ascent/cms/form/components/ascent-pivotlist.css)
    @endpush

    @push('scripts')
        @script(/vendor/ascent/cms/form/components/ascent-pivotlist.js)
    @endpush
@endonce

@push('scripts')
    <script language="javascript">
        $(document).ready(function() {
            
            $('#{{$name}}').pivotlist({
                labelField: '{{$labelField}}',
                data: @json($value),
                placeholder: 'Type a few characters...'

            });

        });
    </script>
@endpush

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')
 
   
    <input type="{{$type}}" name="{{$name}}" id="{{$name}}" value="" class="form-control"/>

@overwrite