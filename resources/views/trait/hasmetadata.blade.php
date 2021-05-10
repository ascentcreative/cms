@php
    
$md = $model->metadata;

@endphp


<x-cms-form-textarea label="Description" name="_metadata[description]" value="{{ old('_metadata.description', $md->description ?? '')}}">
    @if(!is_null($gendesc = $model->generateMetaDescription()))Leave blank to use the automatically generated description. @endif
</x-cms-form-textarea>

<x-cms-form-textarea label="Keywords" name="_metadata[keywords]" value="{{ old('_metadata.keywords', $md->keywords ?? '')}}">
    @if(!is_null($genkey = $model->generateMetaKeywords()))Leave blank to use the automatically generated keywords. @endif
</x-cms-form-textarea>
