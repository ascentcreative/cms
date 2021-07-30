@php 
    $blockid = "block-" . uniqid();
@endphp

<div class="block-edit">

    <div class="block-handle bi-arrow-down-up">

    </div>

    <div class="block-content" id="">
        @yield('block-content')
    </div>

    <div class="block-settings">

        <div class="controls">
         
            <div style="flex-basis: 100%; flex-shrink: 1">
                @yield('block-actions')
            </div>
         

            <A href="#" class="block-open-settings bi-gear" data-toggle="modal" data-target="#{{ $blockid }}"></A>

            <A href="#" class="block-delete bi-trash"></A>

        </div>

      
        {{-- Wrap settings in a modal --}}
        <x-cms-modal modalid="{{ $blockid }}" title="Block Settings" :closebutton="false">

            <div class="container">
            @section('block-settings')
            
               
            @show


                <x-cms-form-input type="text" name="{{ $name }}[contentwidth]" label="Content Width" :value="$value->contentwidth ?? ''">
                    The width of the screen to use for the content. Leave blank for the default centralised portion, or enter values in % or px. <br/>
                    <strong>Examples:<br/></strong>
                    <code>100%</code> will use the full screen width.<br/>
                    <code>500px</code> will use the central 500px of the screen (or shrink if narrower)
                </x-cms-form-input>

                {{-- <x-cms-form-checkbox type="" name="{{ $name }}[fullwidth]" label="Full Width?" :value="$value->fullwidth ?? ''">
                </x-cms-form-checkbox> --}}

                <x-cms-form-colour label="Background Colour" name="{{ $name }}[bgcolor]" :value="$value->bgcolor ?? 'white'" />


                <div class="border p-2 mb-2">
                    <div><strong>Padding</strong></div>
                    <x-cms-form-input type="text" name="{{ $name }}[padding][top]" label="Top" :value="$value->padding->top ?? 0"/>
                    <x-cms-form-input type="text" name="{{ $name }}[padding][bottom]" label="Bottom" :value="$value->padding->bottom ?? 0"/>
                    <x-cms-form-input type="text" name="{{ $name }}[padding][left]" label="Left" :value="$value->padding->left ?? 0"/>
                    <x-cms-form-input type="text" name="{{ $name }}[padding][right]" label="Right" :value="$value->padding->right ?? 0"/>
                </div>

                <div class="border p-2">
                    <div><strong>Margin</strong></div>
                    <x-cms-form-input type="text" name="{{ $name }}[margin][top]" label="Top" :value="$value->margin->top ?? 0"/>
                    <x-cms-form-input type="text" name="{{ $name }}[margin][bottom]" label="Bottom" :value="$value->margin->bottom ?? 0"/>
                    <x-cms-form-input type="text" name="{{ $name }}[margin][left]" label="Left" :value="$value->margin->left ?? 0"/>
                    <x-cms-form-input type="text" name="{{ $name }}[margin][right]" label="Right" :value="$value->margin->right ?? 0"/>
                </div>
        



            </div>

            <x-slot name="footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"> OK </button>
            </x-slot>
            
        </x-cms-modal>
        {{-- End modal --}}
    
        {{-- required hidden fields --}}
        <INPUT type="hidden" name="{{$name}}[type]" value="{{$type}}" />

    </div>


</div>
