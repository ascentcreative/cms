{{-- @dd(request()->all()) --}}

<x-cms-form-stackblock type="{{ $type }}" name="{{ $name }}[{{$key}}]" :value="$value" />

@stack('scripts')