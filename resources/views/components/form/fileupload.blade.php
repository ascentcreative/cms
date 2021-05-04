@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

  

    <div class="ajaxupload form-control" id="{{nameToId($name)}}"">
        <input type="hidden" name="{{$name}}" class="ajaxupload-value" id="{{nameToId($name)}}-value" value="{{ $value }}">
        <input type="file" class="ajaxupload-file"  id="{{nameToId($name)}}-upload">
        <label class="ajaxupload-ui" for="{{ nameToId($name) }}-upload">
            <div class="ajaxupload-display">
                <div class="ajaxupload-progress"></div>
                <div class="ajaxupload-text">
                
                    @if($value) 
                        @php
                            $file = AscentCreative\CMS\Models\File::find($value);
                        @endphp
                        {{ $file->original_name }}
                    @else
                        Choose file
                    @endif
                </div>
            </div>
        </label>
    </div>


@overwrite

@once
    @push('scripts')
        @script('/vendor/ascent/cms/form/components/ascent-ajaxupload.js')
    @endpush
    @push('styles')
        @style('/vendor/ascent/cms/form/components/ascent-ajaxupload.css')
    @endpush
@endonce

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#{{ nameToId($name) }}').ajaxupload({

            });
        });
    </script>
@endpush