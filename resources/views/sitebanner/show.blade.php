<section class="top_banner" @if($banner->bgcolor) style="background: {{ $banner->bgcolor }}" @endif>
    <div class="@if(!isset($banner->use_full_width) || $banner->use_full_width != 1) centralise @endif flex flex-center">
        @if($banner->link_url) 
            <A href="https://memralife.eventsair.com/sh2022-harrogate/" target="_blank">
        @endif

        @if($banner->image_id)
            @php  $file = AscentCreative\CMS\Models\File::find($banner->image_id) @endphp
            <img src="/storage/{{ $file->filepath }}" style="width: 100%;" border="0"/>
        @endif

        @if($banner->link_url) 
            </A>
        @endif
           
    </div>
</section>
