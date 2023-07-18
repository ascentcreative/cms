:root {
    @foreach($swatches as $swatch)
        --{{ $swatch->slug}}: #{{ $swatch->hex }};
    @endforeach
}