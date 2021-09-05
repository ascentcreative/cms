{{-- {!! $content !!} --}}

@isset($content)
    @foreach(json_decode($content) as $item)

        {{-- @dd($item) --}}

       
            <div 

            {{-- This needs to use some form of auto conversion... ie put everythig in a styles property to automatically write to the tag  --}}
           {{--  will also need to know how to format values (although these could be selected on the setting themselves) --}}
            style="position: relative; {{-- @if(isset($item->bgcolor) && $item->bgcolor != '') 
                    background-color: {{ $item->bgcolor }};
                @endif --}} @if(isset($item->padding->top) && $item->padding->top != 0) 
                    padding-top: {{ $item->padding->top }}px;
                @endif  @if(isset($item->padding->bottom) && $item->padding->bottom != 0) 
                    padding-bottom: {{ $item->padding->bottom }}px;
                @endif @if(isset($item->padding->left) && $item->padding->left != 0) 
                    padding-left: {{ $item->padding->left }}px;
                @endif @if(isset($item->padding->right) && $item->padding->right != 0) 
                    padding-right: {{ $item->padding->right }}px;
                @endif @if(isset($item->margin->top) && $item->margin->top != 0) 
                    margin-top: {{ $item->margin->top }}px;
                @endif @if(isset($item->margin->bottom) && $item->margin->bottom != 0) 
                    margin-bottom: {{ $item->margin->bottom }}px;
                @endif @if(isset($item->margin->left) && $item->margin->left != 0) 
                    margin-left: {{ $item->margin->left }}px;
                @endif @if(isset($item->margin->right) && $item->margin->right != 0) 
                    margin-right: {{ $item->margin->right }}px;
                @endif @if(Agent::isMobile() && isset($item->bgimage) && $item->bgimage != '')
                    {{-- Can't use parallax on mobile, so add the image as a normal backrgound --}}
                    background-image: url('/storage/{{ \AscentCreative\CMS\Models\File::find($item->bgimage)->filepath }}');
                    background-size: cover;
                    background-position: center;
                @endif" 
                
                @if(!Agent::isMobile())
                    @if(isset($item->bgimage) && $item->bgimage != '') 
                        {{-- Parallax image for non-mobile users. --}}
                        data-android-fix="false" class="parallax-window" data-parallax="scroll" data-image-src="/storage/{{ \AscentCreative\CMS\Models\File::find($item->bgimage)->filepath }}"
                    @endif
                @endif         

                >

                {{-- To allow for blended BG colours over images, put the color as an overlaid div. --}}
                @if(isset($item->bgcolor) && $item->bgcolor != '') 
                    <div class="bgcolor" style="background-color: {{ $item->bgcolor }}; position: absolute; top: 0; bottom: 0; left: 0; right: 0"></div>
                @endif

            {{-- @if(!isset($item->fullwidth) || !$item->fullwidth)  --}}
                <div 
                    @if(!isset($item->contentwidth) || $item->contentwidth != '100%')
                    class="centralise" 
                    @endif
                    @if(isset($item->contentwidth) && $item->contentwidth != '')
                    style="max-width: {{ $item->contentwidth }}"
                    @endif
                    >
            {{-- //@endif --}}

        
                @includeFirst(['stack.block.' . $item->type . '.show', 'cms::stack.block.' . $item->type . '.show'], ['data'=>$item])

            
            {{-- //@if(!isset($item->fullwidth) || !$item->fullwidth)  --}}
                </div> 
            {{-- @endif --}}
    

        </div>
       
    @endforeach
@endisset