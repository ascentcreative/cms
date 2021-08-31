@php

    
@endphp

<div class="gallery-grid">

    {{-- @foreach($data as $post) 
        <div class="ig-grid-item" style="background-image: url('{{ $post['url'] }}')">

        </div>
    @endforeach --}}

</div>

@once
    @push('styles')
        {{-- @style('/vendor/ascent/cms/css/ascent-igfeed-core.css') --}}
    @endpush

    @push('scripts')
    
    @endpush
@endonce