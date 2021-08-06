@php
    
    $ary = parse_url(trim($url));

@endphp

@isset($ary['host'])

<div class="embed-container">

    @switch($ary['host'])

        @case('youtu.be')
            <iframe src="//www.youtube.com/embed{{ $ary['path'] }}?" frameborder="0" allowfullscreen></iframe>
            @break

        @case('youtube.com')
        @case('www.youtube.com')
            <iframe src="//www.youtube.com/embed/{{ substr($ary['query'], 2) }}?" frameborder="0" allowfullscreen></iframe>
            @break

        @case('vimeo.com')
        @case('www.vimeo.com')
            <iframe src="//player.vimeo.com/video{{ $ary['path'] }}?" frameborder="0" allowfullscreen></iframe>
            @break

        

    @endswitch

</div>

@endisset

