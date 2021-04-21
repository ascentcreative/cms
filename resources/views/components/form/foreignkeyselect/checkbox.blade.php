@extends('cms::components.form.wrapper.' . $wrapper)

@section('label'){{$label}}@overwrite
@section('name'){{$name}}@overwrite

@section('element')

    <div style="columns: 3">
    <?php 
        
       $opts = $query->orderBy($labelField)->get();

        ?>

        @foreach ($opts as $opt)
      
            <label style="display: block">
                <input type="checkbox" name="{{$name}}[]" value="{{ $opt->$idField }}" xclass="form-control" 

                @if(array_search($opt->$idField, array_keys($value->keyBy($idField)->toArray())) !== false)

                {{-- @if (array_search($opt->$idField, $value->toArray() ) !== false) --}}
                    checked="checked"
                @endif 


                /> {{ $opt->$labelField }}
            </label>

       
        @endforeach

    </div>

@overwrite