@php

    if(!$data->account) {
        return;
    }
    
    $profile = \Dymantic\InstagramFeed\Profile::find($data->account); //where('username', 'ascent_creative')->first();



    $data = $profile->refreshFeed($data->imagecount ?? 5);
    
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