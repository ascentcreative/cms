<div class="form-group row">
    <label for="@yield('name')" class="col-sm-1 col-form-label">@yield('label'):</label>
    <div class="col-sm-10">
        @yield('element')
        <small class="form-text text-muted">
            {{ $slot }}
        </small>
        @if($errors->first($name))
            <small class="alert alert-danger form-text" role="alert">
                {{ $errors->first($name) }}
            </small>
        @endif
    </div>
</div> 