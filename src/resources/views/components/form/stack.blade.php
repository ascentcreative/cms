@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    @php 

        // set a default value
    
        if(is_null($value) || $value == '') {

            $obj =  [ 
                    
                    (object)[
                                'type'=>'row',
                                'bgcolor'=>'',
                                'items'=> [
                                    (object) [
                                        'type'=>'text',
                                        'content'=>''
                                    ]

                                ]
                    ]
            ];

            $value = (object) $obj;

        }

    @endphp

    <div class="stack-edit" id="{{$name}}">

        {{-- for each row, show the relevant edit blade --}}
        <div class="stack-blocks">
        @foreach($value as $key=>$block)
            
            <x-cms-form-stackblock type="{{ $block->type }}" name="{{ $name }}[{{$key}}]" :value="$block" />

        @endforeach
        </div>

        <button class="stack-add-block">Add Block</button>


    {{-- 
        This field receives the serialized & stringified JSON on save.
        Using the main field name means that all the actual heirarchical fields are replaced / ignored
    --}}
    <input type="hidden" name="{{$name}}" class="stack-output"/>
    {{-- <textarea name="{{$name}}" class="stack-output" style="width: 100%; height: 400px"></textarea> --}}

    </div>





@overwrite

@once
    @push('styles')
        @style('/vendor/ascent/cms/form/components/ascent-stack-edit.css')
    @endpush
    @push('scripts')
        @script('/vendor/ascent/cms/js/jquery.serializejson.js')
        @script('/vendor/ascent/cms/form/components/ascent-stack-edit.js')
    @endpush
@endonce




@push('scripts')

    <script>
      
        $(document).ready(function() {
            $('.stack-edit#{{$name}}').stackedit();
        });

    </script>

@endpush