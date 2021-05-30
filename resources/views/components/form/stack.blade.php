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
                                // 'items'=> [
                                //     (object) [
                                //         'type'=>'text',
                                //         'content'=>''
                                //     ]

                                // ]
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


        <div class="btn-group dropright">
            <A class="btn btn-secondary btn-sm dropdown-toggle" href="#" data-toggle="dropdown" >Add Block</A>
            <div class="dropdown-menu dropdown-menu-right" style="">

                <a class="stack-add-block dropdown-item text-sm btn-option" href="#" data-block-type="row" data-block-field="content">Text/Image/Video Row</a>

                <a class="stack-add-block dropdown-item text-sm btn-option" href="#" data-block-type="accommodation-list" data-block-field="content">Accommodation List</a>

                <a class="stack-add-block dropdown-item text-sm btn-option" href="#" data-block-type="resource-list" data-block-field="content">Resource List</a>

                <a class="stack-add-block dropdown-item text-sm btn-option" href="#" data-block-type="price-table" data-block-field="content">Price Table</a>

                <a class="stack-add-block dropdown-item text-sm btn-option" href="#" data-block-type="contact-form" data-block-field="content">Contact Form</a>


                {{-- @foreach(\AscentCreative\CMS\Models\BlockTemplate::orderBy('name')->get() as $template)
                <a class="dropdown-item text-sm btn-delete" href="{{ action([AscentCreative\CMS\Controllers\Admin\BlockController::class, 'create'], ['stack_id' => $item->id, 'blocktemplate_id'=>$template->id]) }}">
                <b>{{ $template->name }}</b>
                <br/>
                <span class="text-sm text-muted">{{ $template->description }}</span>

                </a> 
                @endforeach --}}
            </div>
      </div>    

        {{--  --}}


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
        @script('/vendor/ascent/cms/form/components/ascent-stack-block-edit.js')
    @endpush
@endonce




@push('scripts')

    <script>
      
        $(document).ready(function() {
            $('.stack-edit#{{$name}}').stackedit();
        });

    </script>

@endpush