@extends('cms::components.form.wrapper.bootstrapformgroup')

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <select name="{{$name}}" class="form-control">
        <option value="">{{$nullItemLabel}}</option>

        <?php 
        
        //$opts = $model::orderBy($labelField)->get(); 
       $opts = $query->orderBy($labelField)->get();
        
        ?>

        @foreach ($opts as $opt)

        <option value="{{ $opt->$idField }}" @if ($value == $opt->$idField)
            selected
        @endif>{{ $opt->$labelField }}</option>

        @endforeach

    </select>

@overwrite