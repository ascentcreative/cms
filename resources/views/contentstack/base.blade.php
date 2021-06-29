<div id="block_{{ $block->slug }}" style="@isset($data->bgcolor) background-color: {{ $data->bgcolor }};@endisset @isset($data->bgimage) background-size: cover; background-image: url('{{ $data->bgimage }}') @endisset">

    @yield('block')

</div>