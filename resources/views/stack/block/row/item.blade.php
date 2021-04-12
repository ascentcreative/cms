<div class="blockitem" style="width: {{ (100 / 12) * ($value->cols->width ?? 12) }}%;">

    <div class="blockitem-content" style="">

        <div class="blockitem-handle bi-arrow-left-right"></div>
        <a href="" class="blockitem-delete bi-trash"></a>
        
        @switch($type)
            
            @case('text')
                <x-cms-form-wysiwyg label="" name="{{ $name }}[content]" value="{!! isset($value->content) ? $value->content : ''  !!}" wrapper="none"/>
                @break

            @case('image')
                <x-cms-form-croppie width="800" label="" name="{{ $name }}[image]" value="{!! isset($value->image) ? $value->image : ''  !!}" wrapper="none"/>
                @break

            @case('video')
                VIDEO UI
                @break
        
        @endswitch
        
        
        <div style="display: none">
            Cols = Start: <input type="text" name="{{ $name }}[cols][start]" class="item-col-start" value="{{ $value->cols->start ?? 1}}" /> 
            Width: <input type="text" class="item-col-count" name="{{ $name }}[cols][width]" value="{{ $value->cols->width ?? 12 }}" />
            Type: <input type="text" class="item-type" name="{{ $name }}[type]" value="{{ $type }}" />
        </div>

    </div>

</div>