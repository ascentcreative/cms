<div class="blockitem" style="width: {{ (100 / 12) * ($value->cols->width ?? 12) }}%;">

    <div class="blockitem-content" style="background-color: white; height: 100%;">

        <div class="blockitem-handle bi-arrows-move xbi-arrow-left-right"></div>
        <a href="" class="blockitem-delete bi-trash"></a>
        
        @switch($type)
            
            @case('text')
                    <x-cms-form-wysiwyg label="" name="{{ $name }}[content]" value="{!! isset($value->content) ? $value->content : ''  !!}" wrapper="none"/>
                @break

            @case('image')
                <div class="imageitem" style="padding: 10px; width: 100%; padding-right: 30px;">
                        <x-cms-form-croppie width="800" label="" name="{{ $name }}[image]" value="{!! isset($value->image) ? $value->image : ''  !!}" wrapper="none"/>
                </div>
                @break

            @case('video')

                  
                
                    <div class="videoitem" style="padding: 10px; width: 100%; padding-right: 30px;">

                         

                        

                        <div class="text-center pt-2">
                            Video Not Yet Implemented...
                            {{-- <button class="button btn-sm btn btn-primary text-small">Change</button> <button class="button btn-sm btn btn-primary text-small">Options</button> --}}
                        </div>

                    </div> 
                    

                @break
        
        @endswitch
        
        
        <div style="display: none">
            Cols = Start: <input type="text" name="{{ $name }}[cols][start]" class="item-col-start" value="{{ $value->cols->start ?? 1}}" /> 
            Width: <input type="text" class="item-col-count" name="{{ $name }}[cols][width]" value="{{ $value->cols->width ?? 12 }}" />
            Type: <input type="text" class="item-type" name="{{ $name }}[type]" value="{{ $type }}" />
        </div>

    </div>

</div>