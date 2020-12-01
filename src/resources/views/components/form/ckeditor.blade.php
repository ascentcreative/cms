@extends('cms::components.form.bootstrapformgroup')

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@once
    @push('scripts')
        @script('/vendor/ascent/cms/ckeditor/ckeditor.js')
        @script('/vendor/ascent/cms/ckeditor/adapters/jquery.js')
    @endpush
@endonce

@push('scripts')
<script language="javascript">

    var roxyFileman = '/ascentcore/fileman/index.html'; 

      $(document).ready(function(){ 

              
        CKEDITOR.replace($('textarea#{{$name}}')[0], 

        { width : " . $width . ", height : " . $element->getHeight() . ", 
            extraAllowedContent : 'form; form[*]; form(*); input; input(*); input[*]; p[style]; script; script(*); script[*]; iframe; code; embed; iframe[*]; embed[*]; span(*); div(*); div(codesnippet)[*]; div[*]; codesnippet; codesnippet[contenteditable]; codesnippet[partial]; codesnippet[*]', filebrowserBrowseUrl:roxyFileman,
            filebrowserImageBrowseUrl:roxyFileman+'?type=image',
            removeDialogTabs: 'link:upload;image:upload',
            removePlugins : 'elementspath',
            extraPlugins: 'font,richcombo,snippet,photogallery,justify,panel,button,floatpanel,panelbutton,colorbutton,colordialog',
            contentsCss: [ '/css/fck_editorarea.css','/css/buttons.css' ]
           
             }

        ) });

           


for (var idCKE in CKEDITOR.instances) {


   CKEDITOR.instances[idCKE].on('change', function(event) { 
        CKEDITOR.instances[idCKE].updateElement();
        $(CKEDITOR.instances[idCKE].element.$).change();
       
});


 } 	

    </script>
@endpush

@section('element')

    <textarea id="{{$name}}" name="{{$name}}" class="form-control">{!! $value !!}</textarea>

@overwrite