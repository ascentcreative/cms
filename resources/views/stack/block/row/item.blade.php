<div class="blockitem xcol-{{ $value->cols->width ?? 0 /* width to fill gap... */ }}" style="width: {{ (100 / 12) * $value->cols->width }}%; ">

    <div class="blockitem-content" style="margin: 5px; height: 100% ">

        <div class="blockitem-handle">
           <select name="{{ $name }}[type]"><option>text</option><option>image</option><option>video</option></select>
        </div>
        <x-cms-form-wysiwyg label="TESTING" name="{{ $name }}[content]" value="{!! isset($value->content) ? $value->content : ''  !!}" wrapper="none"/>
        <div style="display: none">
            Cols = Start: <input type="text" name="{{ $name }}[cols][start]" value="{{ $value->cols->start ?? 1}}" /> Width: <input type="text" name="{{ $name }}[cols][width]" value="{{ $value->cols->width ?? 1 }}" />
        </div>

    </div>

</div>