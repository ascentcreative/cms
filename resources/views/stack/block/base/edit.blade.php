
<div class="block-edit">

    <div class="block-handle">

    </div>

    <div class="block-content" id="">
        @yield('block-content')
    </div>

    <div class="block-settings">

        <div class="controls" style="display: flex; flex-direction: column; align-items: center; padding: 10px 0 10px 10px; font-size: 1.5rem; height:100%;">
         
            <div style="flex-basis: 100%; flex-shrink: 1">
            @yield('block-actions')
            </div>
         

            <A href="#" class="block-open-settings bi-gear"></A>

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


