<x-cms-form-stackblock-rowitem type="{{ $type }}" name="{{ $name }}" :value="(object)['cols'=>(object)['width'=>$cols]]" />

@stack('scripts')