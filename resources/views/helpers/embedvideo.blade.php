

@php
    
$ary = parse_url($url);

@endphp

<div class="embed-container">

    @switch($ary['host'])

        @case('youtu.be')
            <iframe src="//www.youtube.com/embed{{ $ary['path'] }}?" frameborder="0" allowfullscreen></iframe>
            @break

        

    @endswitch

</div>

