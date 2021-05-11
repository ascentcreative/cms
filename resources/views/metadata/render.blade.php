@php
    $desc = $model->metaDescription ?? '';
    $kwd =  $model->metaKeywords ?? '';
@endphp


<meta name="keywords" content="{{ $kwd }}" />
<meta name="description" content="{{ $desc }}" />

<meta name="og:description" content="{{ $desc }}" />
<meta name="og:updated_time" content="{{ $model ? $model->updated_at->toAtomString() : '' }}" />

<meta name="twitter:description" content="{{ $desc }}" />