<img
    @if($srcset)
        srcset="{{ $srcset }}"
    @else
        src="{{ $src }}"
    @endif
    
   
    @if($sizes && $includeSizes) sizes="{{ $sizes }}" @endif
    alt="{{ $alt }}" 
    @if($class) class="{{ $class }}" @endif
    @if($style) style="{{ $style }}" @endif
    @if($width) width="{{ $width }}" @endif
    @if($height) height="{{ $height }}" @endif
    />