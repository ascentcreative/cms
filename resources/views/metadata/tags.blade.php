
{{-- NOTE - NEEDS UPDATING  --}}

@php
    $desc = $model->metaDescription ?? '';
    $kwd =  $model->metaKeywords ?? '';
@endphp


<meta name="keywords" content="{{ $kwd }}" />
<meta name="description" content="{{ $desc }}" />

<meta name="og:description" content="{{ $desc }}" />
@if($model && !request()->isPreview)
    <meta name="og:updated_time" content="{{ $model->updated_at->toAtomString() ?? '' }}" />
@endif

<meta name="twitter:description" content="{{ $desc }}" /> 