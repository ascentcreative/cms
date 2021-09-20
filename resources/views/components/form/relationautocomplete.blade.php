@extends('cms::components.form.wrapper.bootstrapformgroup')

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <input type="text" id="{{ nameToId($name) }}-entry" name="{{$name}}-entry" placeholder="{{ $placeholder }}" class="form-control" value="{{ $display }}">
    <input type="hidden" id="{{ nameToId($name) }}" name="{{$name}}" value="{{ $value }}" />

@overwrite

@push('scripts')
    <script>
    $('#{{ nameToId($name) }}-entry').autocomplete({
        source: '{{ $dataurl }}',
        select: function(ui, item) {
            console.log(item.item.id);
            $('#{{ nameToId($name) }}').val(item.item.id);
        }
    });
    </script>
@endpush