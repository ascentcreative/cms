
<div class="block-edit">

    <div class="block-handle">

    </div>

    <div class="block-content" id="">
        @yield('block-content')
    </div>

    <div class="block-settings">

        <div class="controls">
            <button></button>

            <A href="#" class="block-delete bi-trash"></A>
        </div>

        <div style="display: none">
            {{-- Wrap settings in a modal --}}
            @yield('block-settings')
            {{-- End modal --}}
        </div>

        {{-- required hidden fields --}}
        <INPUT type="hidden" name="{{$name}}[type]" value="row" />

    </div>


</div>


