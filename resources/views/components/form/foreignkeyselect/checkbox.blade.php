@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <div style="columns: 3">
    <?php 
        
       $opts = $query->orderBy($labelField)->get();
        
        ?>

        @foreach ($opts as $opt)
      
            <div style="">
                <input type="checkbox" name="{{$name}}[]" value="{{ $opt->$idField }}" xclass="form-control" 
                @if (array_search($opt->$idField, $value->toArray() ) !== false)
                    checked="checked"
                @endif 
                /> {{ $opt->$labelField }}
            </div>

       
        @endforeach

    </div>

@overwrite