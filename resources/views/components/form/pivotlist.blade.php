@extends('cms::components.form.wrapper.' . $wrapper)

@once
    @push('styles')
        @style('/vendor/ascent/cms/form/components/ascent-pivotlist.css')
    @endpush

    @push('scripts')
        @script('/vendor/ascent/cms/form/components/ascent-pivotlist.js')
    @endpush
@endonce

@push('scripts')
    <script language="javascript">
        $(document).ready(function() {
            
            $('#{{$id}}').pivotlist({
                optionRoute: '{{$optionRoute}}',
                @if($storeRoute)
                storeRoute: '{{$storeRoute}}',
                @endif
                labelField: '{{$labelField}}',
                data: @json($value),
                placeholder: 'Type a few characters to search...',
                allowItemDrag: 1,
                addToAll: @json($addToAll),
                sortField: '{{$sortField}}',
                pivotField: '{{$pivotField}}',
                pivotFieldLabel: '{{$pivotFieldLabel}}',
                pivotFieldPlaceholder: '{{$pivotFieldPlaceholder}}'

            });

        });
    </script>
@endpush

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <input name="{{$name}}" id="{{$id}}" value="" class="form-control"/>

@overwrite