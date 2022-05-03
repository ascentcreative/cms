<div class="form-group row element-wrapper {{ $class }}" id="{{$name}}-wrapper">
    <label for="@yield('name')" class="col-{{ $labelcols ?? 2 }} col-form-label">@yield('label')</label>

    

    <div class="col">
        @yield('element')
        <div class="error-display" for="{{ $name }}"></div>
        @if($slot)
            <small class="form-text text-muted">
                {{ $slot }}
            </small>
        @endif
        @if($msg = $errors->first(dotName($name)))
            <small class="validation-error alert alert-danger form-text" role="alert">
                {{ $msg }}
            </small>
        @endif
    </div>
</div> 