@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    @if($preelement || $postelement)
        <div class="form-inline">
    @endif

    @if($preelement)
    {{ $preelement }}&nbsp;
    @endif

    <input type="{{$type}}" name="{{$name}}" value="{!! $value !!}" @if($type=='file' && $accept != '') accept="{{ $accept }}" @endif
        class="form-control{{ ($type=='file' ? '-file' : '') }}" 
        @if($required) required @endif

        @if($type=='number') min="0" step="0.01" @endif
        @if($type=='file')
            @if($multiple) multiple @endif
        @endif
        @if($wireModel) wire:model.lazy="{{ $wireModel }}" @endif
        {{-- @if($validators) data-validators="{{ Crypt::encryptString($validators) }}" @endif --}}
        autocomplete="{{ $autocomplete ? 'on' : 'off' }}"
        @if($placeholder) placeholder="{{ $placeholder }}" @endif
        @if($size) size="{{ $size }}" @endif
    />

    @if($postelement)
    &nbsp;{{ $postelement }}
    @endif

    @if($preelement || $postelement)
        </div>
    @endif

@overwrite