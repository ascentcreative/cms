@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    @php
        $opts = $query->orderBy($sortField, $sortDirection)->get();
    @endphp

    @if($readonly)

        <div class="col-form-label  border-bottom p-2">
            @php $display = $opts->keyBy($idField)->get($value)->$labelField ?? ''; @endphp 
            @if($display) 
                {{ $display }}
            @else 
                <span class="text-muted">{{ $nullItemLabel }}</span>
            @endif
        </div>

    @else


        <select name="{{$name}}" class="form-control">
            <option value="">{{$nullItemLabel}}</option>

            

            @foreach ($opts as $opt)

            <option value="{{ $opt->$idField }}" @if ($value == $opt->$idField)
                selected
            @endif>{{ $opt->$labelField }}</option>

            @endforeach

        </select>

    @endif

@overwrite