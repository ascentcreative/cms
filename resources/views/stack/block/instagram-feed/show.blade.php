@php

    $profile = \Dymantic\InstagramFeed\Profile::where('username', 'kieranmetcalfe')->first();

    $data = $profile->feed(5);
    
@endphp

<div class="ig-grid">

    @foreach($data as $post) 
        <div class="ig-grid-item" style="background-image: url('{{ $post['url'] }}')">

        </div>
    @endforeach

</div>

@push('styles')
    @style('/vendor/ascent/cms/css/ascent-igfeed-core.css')
@endpush