@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@php
    $unid = uniqid();
@endphp

@section('element')

   <div class="wysiwyg-editor @if($styled) wysiwyg-editor-styled @endif" style="width: 100%; height: 100%;">

       <div contenteditable="true" id="edit-{{ $unid }}">{!! $value !!}</div>

    </div>

   <div style="display: none">
   output:
   <textarea name="{{$name}}" id="output-{{$unid}}" class="wysiwyg-output">{!! $value !!}</textarea>
   </div>

@overwrite

@once
    @push('lib')
        @script('/vendor/ascent/cms/ckeditor/ckeditor.js', false)
        @script('/vendor/ascent/cms/ckeditor/adapters/jquery.js', false)
    @endpush
@endonce

{{-- @push('styles')

   <style>
       .wysiwyg-editor * {
           white-space: pre-wrap !important;
           tab-size: 10 !important;
       }
    </style>

@endpush --}}

@push('scripts')
<SCRIPT>

   // $(document).ready(function() { 

        var roxyFileman = '/ascentcore/fileman/index.html'; 

        CKEDITOR.disableAutoInline = true;
        var ck = CKEDITOR.inline( 'edit-{{$unid}}',
        
        {  
            extraAllowedContent : 'form; form[*]; form(*); input; input(*); input[*]; p[style]; script; script(*); script[*]; iframe; code; embed; iframe[*]; embed[*]; span(*); div(*); div(codesnippet)[*]; div[*]; codesnippet; codesnippet[contenteditable]; codesnippet[partial]; codesnippet[*]', filebrowserBrowseUrl:roxyFileman,
            filebrowserImageBrowseUrl:roxyFileman+'?type=image',
            removeDialogTabs: 'link:upload;image:upload',
            removePlugins : 'elementspath',

            extraPlugins: 'font,richcombo,snippet,photogallery,justify,panel,button,floatpanel,panelbutton,colorbutton,colordialog',
            contentsCss: [ '/css/fck_editorarea.css','/css/buttons.css' ],
            colorButton_colors: '{{ join(",", \AscentCreative\CMS\Models\Swatch::all()->transform(function($item, $key) { return str_replace('#', '', $item->hex); })->toArray()) }}',
            entities_additional: '#009'
        }   
        
        );

        ck.on('change', function(e) {
                // update the Textarea and fire off a change event (used by Form Dirty checks);
                $('#output-{{$unid}}').val($('#edit-{{$unid}}').html());
                $('#output-{{$unid}}').change();

            });


      
  // });

    
    
        // $(document).delegate('#edit-{{$unid}}', 'keydown', function(e) {
        //     console.log('fwefewf');
        //     var keyCode = e.keyCode || e.which;
        //     if (keyCode == 9) {
        //         e.preventDefault();

        //         document.execCommand('insertHTML', false, '&#009');
           
        //     }
        // });
    

    </SCRIPT>
@endpush