

@php
    
$ary = parse_url($url);

@endphp

@isset($ary['host'])

<div class="embed-container">

    @switch($ary['host'])

        @case('youtu.be')
            <iframe src="//www.youtube.com/embed{{ $ary['path'] }}?" frameborder="0" allowfullscreen></iframe>
            @break

        

    @endswitch

</div>

@endisset

