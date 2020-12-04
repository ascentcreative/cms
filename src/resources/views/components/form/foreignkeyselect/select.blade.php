@extends('cms::components.form.bootstrapformgroup')

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <select name="{{$name}}" class="form-control">
        <option>Please Select:</option>

        <?php 
        
        $opts = $model::orderBy($labelField)->get(); 
        
        ?>

        
        @foreach ($opts as $opt)

        <option value="{{ $opt->$idField }}" @if ($value == $opt->$idField)
            selected
        @endif>{{ $opt->$labelField }}</option>

        @endforeach

    </select>

@overwrite