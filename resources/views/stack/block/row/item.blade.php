<div class="blockitem" style="width: {{ (100 / 12) * ($value->cols->width ?? 12) }}%; ">

    <div class="blockitem-content" style="margin: 5px; xheight: 100% ">

        <div class="blockitem-handle">
           <select name="{{ $name }}[type]"><option>text</option><option>image</option><option>video</option></select>
        </div>
        <x-cms-form-wysiwyg label="TESTING" name="{{ $name }}[content]" value="{!! isset($value->content) ? $value->content : ''  !!}" wrapper="none"/>
        <div style="display: none">
            Cols = Start: <input type="text" name="{{ $name }}[cols][start]" class="item-col-start" value="{{ $value->cols->start ?? 1}}" /> Width: <input type="text" class="item-col-count" name="{{ $name }}[cols][width]" value="{{ $value->cols->width ?? 12 }}" />
        </div>

    </div>

</div>