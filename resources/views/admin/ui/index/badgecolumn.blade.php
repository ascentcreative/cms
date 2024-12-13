<div class="badge {{ $valueclasses[$item->$property] ?? '' }} w-100">

    @isset($display[($val = $item->$property)])
        {{ $display[$val] }}
    @else
        {{ $val }}
    @endif

</div>