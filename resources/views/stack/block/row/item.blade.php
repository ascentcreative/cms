<div class="blockitem xcol-6" style="width: 100%; ">

    <div class="blockitem-content">

        <div class="blockitem-handle">
           <select name="{{ $name }}[type]"><option>text</option><option>image</option><option>video</option></select>
        </div>
        <x-cms-form-wysiwyg label="TESTING" name="{{ $name }}[content]" value="{!! isset($value->content) ? $value->content : ''  !!}" wrapper="none"/>
        <div style="display: none">
            Cols = Start: <input type="text" name="{{ $name }}[cols][start]" value="{{ $value->cols->start ?? 1}}" /> Width: <input type="text" name="{{ $name }}[cols][width]" value="{{ $value->cols->width ?? 1 }}" />
        </div>
    </div>

</div>